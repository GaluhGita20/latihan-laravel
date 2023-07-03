<?php

namespace App\Models\Master;

use App\Models\Model;
use App\Models\Master\Parts;
use App\Models\Master\Plant;
use App\Models\Master\System;
use App\Models\Master\SubUnit;
use App\Models\Master\Komponen;
use App\Models\Master\Equipment;

class InstruksiKerja extends Model
{
    protected $table = 'ref_instruksi_kerja';

    protected $fillable = [
        'tipe_aset',
        'aset_id',
        'name',
        'description'
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

    public function plant(){
        return $this->belongsTo(Plant::class, 'aset_id');
    }

    public function system(){
        return $this->belongsTo(System::class, 'aset_id');
    }

    public function equipment(){
        return $this->belongsTo(Equipment::class, 'aset_id');
    }
    
    public function subUnit(){
        return $this->belongsTo(SubUnit::class, 'aset_id');
    }

    public function komponen(){
        return $this->belongsTo(Komponen::class, 'aset_id');
    }

    public function parts(){
        return $this->belongsTo(Parts::class, 'aset_id');
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
        return $query->filterBy(['name', 'tipe_aset']);
    }

    public function asetName()
    {
        $data = $this->tipe_aset;
        switch ($data) {
            case 'plant':
                $items = $this->plant->name;
                break;
            case 'system':
                $items = $this->system->name;
                break;
            case 'equipment':
                $items = $this->equipment->name;
                break;
            case 'sub-unit':
                $items = $this->subUnit->name;
                break;
            case 'komponen':
                $items = $this->komponen->name;
                break;
            case 'parts':
                $items = $this->parts->name;
                break;   
        }

        return $items;
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
        return true;
    }
}
