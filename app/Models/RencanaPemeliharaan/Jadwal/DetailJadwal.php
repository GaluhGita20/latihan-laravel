<?php

namespace App\Models\RencanaPemeliharaan\Jadwal;

use App\Models\Auth\User;
use App\Models\Master\TipeMaintenance;
use App\Models\Master\ItemPemeliharaan;
use App\Models\Model;
use App\Models\RencanaPemeliharaan\Jadwal\Jadwal;
use App\Models\RencanaPemeliharaan\Jadwal\JadwalDetailPelaksana;
use App\Models\Traits\HasApprovals;
use App\Models\Traits\HasFiles;
use Carbon\Carbon;

class DetailJadwal extends Model
{
    use HasFiles;
    use HasApprovals;

    protected $table = 'trans_detail_jadwal';

    protected $fillable = [
        'tipe_pemeliharaan_id',
        'item_pemeliharaan_id',
        'jadwal_id',
        'bulan',
    ];

    /*******************************
     ** MUTATOR
     *******************************/

    protected $dates = [
        'bulan',
    ];

    /*******************************
     ** ACCESSOR
     *******************************/

    public function setBulanAttribute($value){

        return $this->attributes['bulan'] = Carbon::createFromFormat('d/m/Y', $value);
        
    }
    /*******************************
     ** RELATION
     *******************************/
    public function tipePemeliharaan()
    {
        return $this->belongsTo(TipeMaintenance::class, 'tipe_pemeliharaan_id');
    }

    public function itemPemeliharaan()
    {
        return $this->belongsTo(ItemPemeliharaan::class, 'item_pemeliharaan_id');
    }

    public function jadwalDetailPelaksana()
    {
        return $this->hasMany(JadwalDetailPelaksana::class, 'detail_jadwal_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
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
        return $query->filterBy(['tipe_pemeliharaan_id', 'item_pemeliharaan_id', 'jadwal_id']);
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


