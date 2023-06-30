<?php

namespace App\Models\Purchasing\GoodReceipt;

use Exception;
use App\Models\Model;
use Illuminate\Support\Carbon;
use App\Models\Traits\HasFiles;
use App\Models\Traits\HasApprovals;
use App\Models\Purchasing\PurchaseOrder\PurchaseOrder;

class GoodReceipt extends Model
{
    use HasApprovals;
    use HasFiles;

    protected $table = 'trans_good_receipt';

    protected $fillable = [
        'purchase_order_id',
        'tgl_penerimaan',
        'catatan',
        'status',
    ];

    protected $dates = [
        'tgl_penerimaan',
    ];

    /*******************************
     ** MUTATOR
     *******************************/

    public function setTglPenerimaanAttribute($value)
    {
        $this->attributes['tgl_penerimaan'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    /*******************************
     ** ACCESSOR
     *******************************/

    /*******************************
     ** RELATION
     *******************************/
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    /*******************************
     ** SCOPE
     *******************************/
    public function scopeGrid($query)
    {
        return $query->latest();
    }

    public function scopeFilters($query)
    {
        return $query->filterBy(['tahun'])
            ->when($id = request()->post('id'), function ($qq) use ($id) {
                $qq->where('tahun', $id);
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
            $this->status = $request->is_submit ? 'waiting.approval' : 'draft';
            $this->save();
            $this->saveFiles($request);
            $this->saveLogNotify();
            $redirect = route(request()->get('routes') . '.index');

            return $this->commitSaved(compact('redirect'));
        } catch (Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleSubmitSave($request)
    {
        $this->beginTransaction();
        try {
            $menu = \App\Models\Setting\Globals\Menu::where('module', 'purchasing.good-receipt')->first();
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
            $this->fill($request->all());
            $this->status = $request->is_submit ? 'waiting.approval' : 'draft';
            $this->save();
            $this->saveFiles($request);
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
        $data = 'Data Good Receipt dengan ID Purchase Order ' . $this->purchaseOrder->id_purchase_order;
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
        return true;
    }
}
