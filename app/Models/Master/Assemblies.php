<?php

namespace App\Models\Master;

use App\Imports\Master\ExampleImport;
use App\Models\Model;
use App\Models\Setting\Globals\TempFiles;

class Assemblies extends Model
{
    protected $table = 'ref_assemblies';

    protected $fillable = [
        'code',
        'name',
        'status_aset_id',
        'kondisi_aset_id',
        'tipe_aset_id',
        'location_id',
        'sub_lokasi_id',
        'aset_id',
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
    public function kondisiAset()
    {
        return $this->belongsTo(KondisiAset::class, 'kondisi_aset_id');
    }
    public function statusAset()
    {
        return $this->belongsTo(StatusAset::class, 'status_aset_id');
    }
    public function tipeAset()
    {
        return $this->belongsTo(TipeAset::class, 'tipe_aset_id');
    }
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'location_id');
    }
    public function subLokasi()
    {
        return $this->belongsTo(SubLokasi::class, 'sub_lokasi_id');
    }
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
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
        return $query->filterBy(['name','code']);
    }

    /*******************************
     ** SAVING
     *******************************/
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $this->fill($request->all());
            $this->save();
            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
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

    public function handleImport($request)
    {
        $this->beginTransaction();
        try {
            $file = TempFiles::find($request->uploads['temp_files_ids'][0]);
            if (!$file || !\Storage::disk('public')->exists($file->file_path)) {
                $this->rollback('File tidak tersedia!');
            }

            $filePath = \Storage::disk('public')->path($file->file_path);
            \Excel::import(new ExampleImport(), $filePath);

            $this->saveLogNotify();

            return $this->commitSaved();
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function saveLogNotify()
    {
        $data = $this->name;
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
        }
    }

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/
    public function canDeleted()
    {
        // if($this->moduleRelations()->exists()) return false;

        return true;
    }
}
