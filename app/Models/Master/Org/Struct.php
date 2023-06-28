<?php

namespace App\Models\Master\Org;

use App\Imports\Setting\StructImport;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Model;

class Struct extends Model
{
    protected $table = 'sys_structs';

    protected $fillable = [
        'parent_id',
        'level', //root, bod, unit, division, branch, bagian, subbagian
        'type', //1:presdir, 2:direktur, 3: division, 4:it division
        'name',
        'code',
        'website',
        'email',
        'phone',
        'address',
    ];

    /** MUTATOR **/

    /** ACCESSOR **/
    public function getShowLevelAttribute()
    {
        switch ($this->level) {
            case 'boc':
                return __('Pengawas');
                break;
            case 'bod':
                return __('Direktur');
                break;
            case 'unit':
                return __('Unit Pelaksana');
                break;
            case 'division':
                return __('Divisi');
                break;
            case 'department':
                return __('Departemen');
                break;
            case 'bagian':
                return __('Bagian');
                break;
            case 'subbagian':
                return __('Sub Bagian');
                break;
            case 'branch':
                return __('Cabang');
                break;
            case 'subbranch':
                return __('Cabang Pembantu');
                break;

            default:
                return ucfirst($this->level);
                break;
        }
    }

    /** RELATION **/
    public function parent()
    {
        return $this->belongsTo(Struct::class, 'parent_id');
    }

    public function parents()
    {
        return $this->belongsTo(Struct::class, 'parent_id')->with('parent');
    }

    public function child()
    {
        return $this->hasMany(Struct::class, 'parent_id')->orderBy('level');
    }

    public function childs()
    {
        return $this->hasMany(Struct::class, 'parent_id')->orderBy('level')->with('child');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'location_id');
    }

    /** SCOPE **/
    public function scopeFilters($query)
    {
        return $query->filterBy(['code', 'name', 'parent_id'])->defaultOrderBy();
    }

    public function scopeRoot($query)
    {
        return $query->where('level', 'root');
    }

    public function scopeBoc($query)
    {
        return $query->where('level', 'boc');
    }

    public function scopeBod($query)
    {
        return $query->where('level', 'bod');
    }

    public function scopeUnit($query)
    {
        return $query->where('level', 'unit');
    }

    public function scopePresdir($query)
    {
        return $query->bod()->where('type', 'presdir');
    }

    public function scopeDirector($query)
    {
        return $query->bod()->where('type', '!=', 'presdir');
    }

    public function scopeDivision($query)
    {
        return $query->where('level', 'division');
    }

    public function scopeDivisionIa($query)
    {
        return $query->division()->where('type', 'ia');
    }

    public function scopeDivisionIt($query)
    {
        return $query->division()->where('type', 'it');
    }

    public function scopeDepartment($query)
    {
        return $query->where('level', 'department');
    }

    public function scopeDepartmentIa($query)
    {
        return $query->department()
            ->whereHas(
                'parent',
                function ($q) {
                    $q->divisionIa();
                }
            );
    }

    public function scopeBranch($query)
    {
        return $query->where('level', 'branch');
    }

    public function scopeSubbranch($query)
    {
        return $query->where('level', 'subbranch');
    }

    public function scopeBagian($query)
    {
        return $query->where('level', 'bagian');
    }
    public function scopeSubbagian($query)
    {
        return $query->where('level', 'subbagian');
    }

    public function scopeInAudit($query)
    {
        return $query->where(
            function ($q) {
                $q->where(
                    function ($qq) {
                        $qq->divisionIa();
                    }
                )->orWhere(
                    function ($qq) {
                        $qq->departmentIa();
                    }
                );
            }
        );
    }

    /** SAVE DATA **/
    public function handleStoreOrUpdate($request, $level)
    {
        $this->beginTransaction();
        try {
            if (in_array($level, ['boc', 'bod', 'division', 'other'])) {
                if ($root = static::root()->first()) {
                    $this->phone = $root->phone;
                    $this->address = $root->address;
                }
            }
            $this->fill($request->all());
            $this->level = $level;
            $this->code = $this->code ?: $this->getNewCode($level);
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

    public function handleImport($request, $level)
    {
        $this->beginTransaction();
        try {
            $file = TempFiles::find($request->uploads['temp_files_ids'][0]);
            if (!$file || !\Storage::disk('public')->exists($file->file_path)) {
                $this->rollback('File tidak tersedia!');
            }

            $filePath = \Storage::disk('public')->path($file->file_path);
            \Excel::import(new StructImport($level), $filePath);

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
            case $routes . '.store':
                $this->addLog('Membuat Data ' . $data);
                break;
            case $routes . '.update':
                $this->addLog('Mengubah Data ' . $data);
                break;
            case $routes . '.destroy':
                $this->addLog('Menghapus Data ' . $data);
                break;
            case $routes . '.importSave':
                auth()->user()->addLog('Import Data Master Struktur Organisasi');
                break;
        }
    }

    /** OTHER FUNCTIONS **/
    public function canDeleted()
    {
        if (in_array($this->type, ['presdir'])) return false;
        if (in_array($this->level, ['root', 'boc'])) return false;
        if ($this->child()->exists()) return false;
        if ($this->positions()->exists()) return false;

        return true;
    }

    public function getNewCode($level)
    {
        switch ($level) {
            case 'root':
                $max = static::root()->max('code');
                return $max ? $max + 1 : 1001;
            case 'boc':
                $max = static::boc()->max('code');
                return $max ? $max + 1 : 1101;
            case 'bod':
                $max = static::bod()->max('code');
                return $max ? $max + 1 : 2001;
            case 'unit':
                $max = static::division()->max('code');
                return $max ? $max + 1 : 3001;
            case 'division':
                $max = static::division()->max('code');
                return $max ? $max + 1 : 4001;
            case 'department':
                $max = static::department()->max('code');
                return $max ? $max + 1 : 5001;
            case 'branch':
                $max = static::branch()->max('code');
                return $max ? $max + 1 : 6001;
            case 'subbranch':
                $max = static::subbranch()->max('code');
                return $max ? $max + 1 : 7001;
            case 'bagian':
                $max = static::bagian()->max('code');
                return $max ? $max + 1 : 8001;
            case 'subbagian':
                $max = static::subbagian()->max('code');
                return $max ? $max + 1 : 9001;
        }
        return null;
    }

    public function getIdsWithChild()
    {
        $ids = [$this->id];
        foreach ($this->child as $child) {
            $ids = array_merge($ids, $child->getIdsWithChild());
        }
        return $ids;
    }
}
