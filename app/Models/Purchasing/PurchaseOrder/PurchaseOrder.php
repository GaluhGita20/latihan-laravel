<?php

namespace App\Models\Purchasing\PurchaseOrder;

use Exception;
use App\Models\Model;
use Illuminate\Support\Carbon;
use App\Models\Traits\HasFiles;
use App\Models\Master\VendorAset;
use App\Models\Purchasing\GoodReceipt\GoodReceipt;
use App\Models\Traits\HasApprovals;
use App\Models\Purchasing\PurchaseOrder\PurchaseOrderDetail;

class PurchaseOrder extends Model
{
    use HasApprovals;
    use HasFiles;

    protected $table = 'trans_purchase_order';

    protected $fillable = [
        'id_purchase_order',
        'tgl_purchase_order',
        'tgl_kirim',
        'vendor_id',
        'catatan',
        'status',
    ];

    protected $dates = [
        'tgl_purchase_order',
        'tgl_kirim',
    ];

    /*******************************
     ** MUTATOR
     *******************************/

    public function setTglPurchaseOrderAttribute($value)
    {
        $this->attributes['tgl_purchase_order'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setTglKirimAttribute($value)
    {
        $this->attributes['tgl_kirim'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    /*******************************
     ** ACCESSOR
     *******************************/

    /*******************************
     ** RELATION
     *******************************/
    public function vendor()
    {
        return $this->belongsTo(VendorAset::class, 'vendor_id');
    }

    public function detail()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id');
    }

    public function goodReceipt()
    {
        return $this->hasOne(GoodReceipt::class, 'purchase_order_id');
    }
    /*******************************
     ** SCOPE
     *******************************/
    public function scopeGrid($query)
    {
        return $query->latest();
    }

    public function scopeGoodReceiptGrid($query)
    {
        return $query->where('status', 'completed')->latest();
    }

    public function scopeFilters($query)
    {
        return $query->filterBy(['id_purchase_order'])
            ->when($id = request()->post('id'), function ($qq) use ($id) {
                $qq->where('id_purchase_order', $id);
            });
    }

    /*******************************
     ** SAVING
     *******************************/

    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->all());
            $this->status = 'draft';
            $this->save();
            $this->saveLogNotify();

            $redirect = route(request()->get('routes') . '.index');

            return $this->commitSaved(compact('redirect'));
        } catch (Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleDestroy()
    {
        $this->beginTransaction();
        try {
            $this->saveLogNotify();
            $this->delete();

            return $this->commitDeleted();
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    public function handleSubmitSave($request)
    {
        $this->beginTransaction();
        try {
            $menu = \App\Models\Setting\Globals\Menu::where('module', 'purchasing.purchase-order')->first();
            if ($request->is_submit == 1) {
                if ($menu->flows()->get()->groupBy('order')->count() == null) {
                    return $this->rollback(
                        [
                            'message' => 'Belum Ada Alur Persetujuan!'
                        ]
                    );
                }
                $this->generateApproval($request->module);
            }
            $this->saveFiles($request);
            $this->fill($request->all());
            $this->status = $request->is_submit ? 'waiting.approval' : 'draft';
            $this->save();
            $this->saveLogNotify();

            $redirect = route(request()->get('routes') . '.index');
            return $this->commitSaved(compact('redirect'));
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveFiles($request)
    {
        $this->saveFilesByTemp($request->attachments, $request->module, 'attachments');
    }

    public function handleReject($request)
    {
        $this->beginTransaction();
        try {
            $this->rejectApproval($request->module, $request->note);
            $this->update(['status' => 'rejected']);
            $this->saveLogNotify();

            $redirect = route(request()->get('routes') . '.index');
            return $this->commitSaved(compact('redirect'));
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleApprove($request)
    {
        $this->beginTransaction();
        try {
            $this->approveApproval($request->module);
            if ($this->firstNewApproval($request->module)) {
                $this->update(['status' => 'waiting.approval']);
            } else {
                $this->update(['status' => 'completed']);
                $receipt = $this->goodReceipt()->firstOrNew([
                    'purchase_order_id' => $this->id,
                    'status' => 'new'
                ]);
                $receipt->save();

                // GoodReceipt::create([
                //     'purchase_order_id' => $this->id,
                // ]);
            }
            $this->saveLogNotify();

            $redirect = route(request()->get('routes') . '.index');
            return $this->commitSaved(compact('redirect'));
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveLogNotify()
    {
        $data = 'Data Purchase Order dengan ID Purchase Order ' . $this->id_purchase_order;
        $routes = request()->get('routes');
        switch (request()->route()->getName()) {
            case $routes . '.store':
                $this->addLog('Membuat ' . $data);
                break;
            case $routes . '.update':
                $this->addLog('Mengubah ' . $data);
                break;
            case $routes . '.destroy':
                $this->addLog('Menghapus ' . $data);
                break;
            case $routes . '.submitSave':
                $this->addLog('Submit ' . $data);
                $this->addNotify([
                    'message' => 'Waiting Approval ' . $data,
                    'url' => route($routes . '.approval', $this->id),
                    'user_ids' => $this->getNewUserIdsApproval(request()->get('module')),
                ]);
                break;
            case $routes . '.approve':
                $this->addLog('Menyetujui ' . $data);
                $this->addNotify([
                    'message' => 'Waiting Approval ' . $data,
                    'url' => route($routes . '.approval', $this->id),
                    'user_ids' => $this->getNewUserIdsApproval(request()->get('module')),
                ]);
                break;
            case $routes . '.reject':
                $this->addLog('Menolak ' . $data . ' dengan alasan: ' . request()->get('note'));
                break;
        }
    }

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/

    public function checkAction($action, $perms, $summary = null)
    {
        $user = auth()->user();

        switch ($action) {
            case 'create':
                return $user->checkPerms($perms . '.view');
                break;

            case 'show':
            case 'history':
                return $user->checkPerms($perms . '.view');
                break;

            case 'edit':
                $checkStatus = in_array($this->status, ['new', 'draft', 'rejected']);
                return $checkStatus && $user->checkPerms($perms . '.edit');
                break;

            case 'delete':
                $checkStatus = in_array($this->status, ['new', 'draft', 'rejected']);
                return $checkStatus && $user->checkPerms($perms . '.delete');
                break;

            case 'approval':
                if ($this->checkApproval(request()->get('module'))) {
                    $checkStatus = in_array($this->status, ['waiting.approval']);
                    return $checkStatus && $user->checkPerms($perms . '.approve');
                }
                break;

            case 'tracking':
                $checkStatus = in_array($this->status, ['waiting.approval', 'completed']);
                return $checkStatus && $user->checkPerms($perms . '.view');
                break;

            case 'print':
                $checkStatus = in_array($this->status, ['waiting.approval', 'completed']);
                return $checkStatus && $user->checkPerms($perms . '.view');
                break;

            default:
                return false;
                break;
        }
    }

    public function canDeleted()
    {
        if($this->detail()->exists()) return false;
        return true;
    }
}
