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
                        $this->makeColumn('name:name|label:Id Aset|className:text-left'),
                        $this->makeColumn('name:name|label:Id Instruksi|className:text-left'),
                        $this->makeColumn('name:name|label:Keterangan|className:text-left'),
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
            ->rawColumns(['action', 'updated_by', 'location'])
            ->make(true);
    }

    public function create()
    {
        $ASETS      = Aset::orderBy('code', 'ASC')->get();
        $PARTS      = Parts::orderBy('code', 'ASC')->get();
        $ASSEMBLIES = Assemblies::orderBy('code', 'ASC')->get();
        return $this->render(
            $this->views . '.create',
            compact('ASETS', 'PARTS', 'ASSEMBLIES')
        );
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
        $ASETS      = Aset::orderBy('code', 'ASC')->get();
        $PARTS      = Parts::orderBy('code', 'ASC')->get();
        $ASSEMBLIES = Assemblies::orderBy('code', 'ASC')->get();
        return $this->render(
            $this->views . '.edit',
            compact('record', 'ASETS', 'PARTS', 'ASSEMBLIES')
        );
    }

    public function update(InstruksiKerjaRequest $request, InstruksiKerja $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(InstruksiKerja $record)
    {
        return $record->handleDestroy();
    }

    public function import()
    {
        if (request()->get('download') == 'template') {
            return $this->template();
        }
        return $this->render($this->views . '.import');
    }

    public function template()
    {
        $fileName = date('Y-m-d') . ' Template Import Data ' . $this->prepared('title') . '.xlsx';
        $view = $this->views . '.template';
        $data = [];
        return \Excel::download(new GenerateExport($view, $data), $fileName);
    }

    public function importSave(Request $request)
    {
        $request->validate(
            [
                'uploads.uploaded' => 'required',
                'uploads.temp_files_ids.*' => 'required',
            ],
            [],
            [
                'uploads.uploaded' => 'File',
                'uploads.temp_files_ids.*' => 'File',
            ]
        );

        $record = new InstruksiKerja;
        return $record->handleImport($request);
    }
}
