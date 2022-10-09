<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AssembliesRequest;
use App\Models\Master\Assemblies;
use App\Models\Master\StatusAset;
use App\Models\Master\KondisiAset;
use App\Models\Master\TipeAset;
use App\Models\Master\Lokasi;
use App\Models\Master\SubLokasi;
use App\Models\Master\Aset;
use Illuminate\Http\Request;

class AssembliesController extends Controller
{
    protected $module   = 'master.assemblies';
    protected $routes   = 'master.assemblies';
    protected $views    = 'master.assemblies';
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
                'title' => 'Assemblies',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Assemblies' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:code|label:Id Assemblies|className:text-left'),
                        $this->makeColumn('name:name|label:Nama Assemblies|className:text-left'),
                        $this->makeColumn('name:code|label:Id Aset|className:text-left'),
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
        $records = Assemblies::with('statusAset', 'kondisiAset', 'tipeAset', 'lokasi', 'subLokasi', 'aset')
            ->grid()
            ->filters()
            ->dtGet();

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
        $STATUSASET  = StatusAset::orderBy('name', 'ASC')->get();
        $KONDISIASET = KondisiAset::orderBy('name', 'ASC')->get();
        $TIPEASET = TipeAset::orderBy('name', 'ASC')->get();
        $LOKASI = Lokasi::orderBy('name', 'ASC')->get();
        $SUBLOKASI = SubLokasi::orderBy('name', 'ASC')->get();
        $ASET = Aset::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.create',
            compact(
                'STATUSASET',
                'KONDISIASET',
                'TIPEASET',
                'LOKASI',
                'SUBLOKASI',
                'ASET'
            )
        );
    }

    public function store(AssembliesRequest $request)
    {
        $record = new Assemblies;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Assemblies $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Assemblies $record)
    {
        $STATUSASET  = StatusAset::orderBy('name', 'ASC')->get();
        $KONDISIASET = KondisiAset::orderBy('name', 'ASC')->get();
        $TIPEASET = TioeAset::orderBy('name', 'ASC')->get();
        $LOKASI = Lokasi::orderBy('name', 'ASC')->get();
        $SUBLOKASI = SubLokasi::orderBy('name', 'ASC')->get();
        $ASET = Aset::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.edit',
            compact(
                'record',
                'STATUSASET',
                'KONDISIASET',
                'TIPEASET',
                'LOKASI',
                'SUBLOKASI',
                'ASET'
            )
        );
    }

    public function update(AssembliesRequest $request, Assemblies $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Assemblies $record)
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

        $record = new Example;
        return $record->handleImport($request);
    }
}
