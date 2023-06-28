<?php

namespace App\Models\RencanaPemeliharaan\Jadwal;

use App\Models\Auth\User;
use App\Models\Master\Aset;
use App\Models\Master\Lokasi;
use App\Models\Master\SubLokasi;
use App\Models\Model;
use App\Models\RencanaPemeliharaan\Jadwal\DetailJadwal;
use App\Models\Traits\HasApprovals;
use App\Models\Traits\HasFiles;
use Carbon\Carbon;

class Jadwal extends Model
{
    use HasFiles;
    use HasApprovals;

    protected $table = 'trans_jadwal';

    protected $fillable = [
        'year',
        'unit_kerja_id',
        'location_id',
        'sub_location_id',
        'aset_id',
        'uraian',
        'status',
    ];

    /*******************************
     ** MUTATOR
     *******************************/

    /*******************************
     ** ACCESSOR
     *******************************/

    /*******************************
     ** RELATION
     *******************************/

    public function user()
    {
        return $this->belongsTo(User::class, 'unit_kerja_id');
    }

     public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }

    public function location()
    {
        return $this->belongsTo(Lokasi::class, 'location_id');
    }

    public function subLocation()
    {
        return $this->belongsTo(SubLokasi::class, 'sub_location_id');
    }

    public function detailJadwal()
    {
        return $this->hasMany(DetailJadwal::class, 'jadwal_id');
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
        return $query->filterBy(['year', 'unit_kerja_id']);
    }

    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {

            $this->fill($request->all());
            $this->status = 'draft';
            $this->save();
            $this->saveFiles($request);
            $this->saveLogNotify();

            if ($request->is_submit) {
                return $this->commitSaved(['redirectToModal' => route($request->routes.'.submit', $this->id)]);
            }

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveFiles($request)
    {
        $this->saveFilesByTemp($request->attachments, $request->module, 'attachments');
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
            $menu = Apps\Models\Setting\Globals\Menu::where('module', 'rencana-pemeliharaan/jadwal')->first();
            if ($request->is_submit == 1) {
                if ($menu->flows()->get()->groupBy('order')->count() == null){
                    return $this->rollback(
                        [
                            'message' => 'Tidak ada flow approval yang diatur.'
                        ]
                    );
                }
                $this->generateApproval($request->module);
            }
            $this->fill($request->all());
            $this->status = $request->is_submit ? 'waiting.approval' : 'draft';
            $this->save();
            $this->saveParts($request);
            $this->saveLogNotify();

            $redirect = route(request()->get('routes').'.index');
            return $this->commitSaved(compact('redirect'));
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleReject($request)
    {
        $this->beginTransaction();
        try {
            $this->rejectApproval($request->module, $request->note);
            $this->update(['status' => 'rejected']);
            $this->saveLogNotify();

            $redirect = route(request()->get('routes').'.index');
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

            $redirect = route(request()->get('routes').'.index');
            return $this->commitSaved(compact('redirect'));
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveLogNotify()
    {
        $data = \Base::getModules(request()->get('module')).' Tahun '.$this->year;
        $routes = request()->get('routes');
        switch (request()->route()->getName()) {
            case $routes.'.store':
                $this->addLog('Membuat Data '.$data);
                break;
            case $routes.'.update':
                $this->addLog('Mengubah Data '.$data);
                break;
            case $routes.'.destroy':
                $this->addLog('Menghapus Data '.$data);
                break;
            case $routes.'.submitSave':
                $this->addLog('Submit Data '.$data);
                $this->addNotify([
                    'message' => 'Waiting Approval '.$data,
                    'url' => route($routes.'.approval', $this->id),
                    'user_ids' => $this->getNewUserIdsApproval(request()->get('module')),
                ]);
                break;
            case $routes.'.approve':
                $this->addLog('Menyetujui Data '.$data);
                $this->addNotify([
                    'message' => 'Waiting Approval '.$data,
                    'url' => route($routes.'.approval', $this->id),
                    'user_ids' => $this->getNewUserIdsApproval(request()->get('module')),
                ]);
                break;
            case $routes.'.reject':
                $this->addLog('Menolak Data '.$data.' dengan alasan: '.request()->get('note'));
                break;
        }
    }

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/
    public function checkAction($action, $perms)
    {
        $user = auth()->user();

        switch ($action) {
            case 'create':
                return $user->checkPerms($perms.'.create');
                break;

            case 'edit':
                $checkStatus = in_array($this->status, ['new','draft','rejected']);
                return $checkStatus && $user->checkPerms($perms.'.edit');
                break;

            case 'show':
            case 'history':
                return $user->checkPerms($perms.'.view');
                break;

            case 'delete':
                $checkStatus = in_array($this->status, ['new','draft']);
                return $checkStatus && $user->checkPerms($perms.'.delete');
                break;

            case 'approval':
                if ($this->checkApproval(request()->get('module'))) {
                    $checkStatus = in_array($this->status, ['waiting.approval']);
                    return $checkStatus && $user->checkPerms($perms.'.view');
                }
                break;

            case 'tracking':
                $checkStatus = in_array($this->status, ['waiting.approval']);
                return $checkStatus && $user->checkPerms($perms.'.view');
                break;
        }

        return false;
    }
}

