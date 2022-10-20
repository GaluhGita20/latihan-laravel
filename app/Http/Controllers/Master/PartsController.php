<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PartsRequest;
use App\Models\Master\Parts;
use App\Models\Master\KondisiAset;
use App\Models\Master\StatusAset;
use App\Models\Master\TipeAset;
use App\Models\Master\Lokasi;
use App\Models\Master\SubLokasi;
use App\Models\Master\Assemblies;
use Illuminate\Http\Request;

class PartsController extends Controller
{
    protected $module   = 'master.parts';
    protected $routes   = 'master.parts';
    protected $views    = 'master.parts';
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
                'title' => 'Parts',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Parts' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:code|label:Id Parts|className:text-left'),
                        $this->makeColumn('name:name|label:Nama Parts|className:text-left'),
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
        $records = Parts::with(
            'kondisiAset',
            'statusAset',
            'tipeAset',
            'lokasi',
            'subLokasi'
            )
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
        // $ASSEMBLIES = Assemblies::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.create',
            compact(
                'STATUSASET',
                'KONDISIASET',
                'TIPEASET',
                'LOKASI',
                'SUBLOKASI',
                // 'ASSEMBLIES'
                )
        );
    }

    public function store(PartsRequest $request)
    {
        $record = new Parts;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Parts $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Parts $record)
    {
        $STATUSASET  = StatusAset::orderBy('name', 'ASC')->get();
        $KONDISIASET = KondisiAset::orderBy('name', 'ASC')->get();
        $TIPEASET = TipeAset::orderBy('name', 'ASC')->get();
        $LOKASI = Lokasi::orderBy('name', 'ASC')->get();
        $SUBLOKASI = SubLokasi::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.edit',
            compact(
                'record',
                'STATUSASET',
                'KONDISIASET',
                'TIPEASET',
                'LOKASI',
                'SUBLOKASI'
            )
        );
    }

    public function update(PartsRequest $request, Parts $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Parts $record)
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
