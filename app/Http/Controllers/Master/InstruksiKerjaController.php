<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\InstruksiKerjaRequest;
use App\Models\Master\Aset;
use App\Models\Master\Assemblies;
use App\Models\Master\InstruksiKerja;
use App\Models\Master\Geo\Province;
use App\Models\Master\Parts;
use Illuminate\Http\Request;

class InstruksiKerjaController extends Controller
{
    protected $module   = 'master.instruksi-kerja';
    protected $routes   = 'master.instruksi-kerja';
    protected $views    = 'master.instruksi-kerja';
    protected $perms    = 'master';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Instruksi Kerja',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Instruksi Kerja' => route($this->routes . '.index'),
                ]
            ]
        );
    }

    public function index()
    {
        $this->prepare(
            [
                'tableStruct' => [
                    'datatable_1' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:name|label:Nama|className:text-left'),
                        $this->makeColumn('name:description|label:Deskripsi|className:text-center'),
                        $this->makeColumn('name:tipe_aset|label:Tipe Aset|className:text-center'),
                        $this->makeColumn('name:aset_id|label:Aset|className:text-center'),
                        $this->makeColumn('name:updated_by'),
                        $this->makeColumn('name:action'),
                    ],
                ],
            ]
        );
        return $this->render($this->views . '.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = InstruksiKerja::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'description',
                function ($record) {
                    $totalWords = str_word_count($record->description);
                    return '<span>'. $totalWords .' Words</span>';
                }
            )
            ->addColumn(
                'tipe_aset',
                function ($record) {
                    return '<span>'. ucfirst(str_replace("-"," ",$record->tipe_aset)) .'</span>';
                }
            )
            ->addColumn(
                'aset_id',
                function ($record) {
                    switch ($record->tipe_aset) {
                        case 'plant':
                            $items = $record->plant->name;
                            break;
                        case 'system':
                            $items = $record->system->name;
                            break;
                        case 'equipment':
                            $items = $record->equipment->name;
                            break;
                        case 'sub-unit':
                            $items = $record->subUnit->name;
                            break;
                        case 'komponen':
                            $items = $record->komponen->name;
                            break;
                        case 'parts':
                            $items = $record->parts->name;
                            break;   
                    }
                    return '<span>'. $items .'</span>';
                }
            )
            ->addColumn(
                'updated_by',
                function ($record) {
                    return $record->createdByRaw();
                }
            )
            ->addColumn(
                'action',
                function ($record) use ($user) {
                    $actions = [
                        'type:show|id:' . $record->id,
                        'type:edit|id:' . $record->id,
                    ];
                    if ($record->canDeleted()) {
                        $actions[] = [
                            'type' => 'delete',
                            'id' => $record->id,
                            'attrs' => 'data-confirm-text="' . __('Hapus') . ' ' . $record->name . '?"',
                        ];
                    }
                    return $this->makeButtonDropdown($actions);
                }
            )
            ->rawColumns(['action', 'updated_by', 'description', 'aset_id', 'tipe_aset'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(InstruksiKerjaRequest $request)
    {
        $record = new InstruksiKerja;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(InstruksiKerja $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(InstruksiKerja $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(InstruksiKerjaRequest $request, InstruksiKerja $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(InstruksiKerja $record)
    {
        return $record->handleDestroy();
    }
}
