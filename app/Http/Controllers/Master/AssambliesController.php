<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AssambliesRequest;
use App\Models\Master\Assamblies;
use App\Models\Master\StatusAset;
use App\Models\Master\KondisiAset;
use App\Models\Master\TipeAset;
use App\Models\Master\Lokasi;
use App\Models\Master\SubLokasi;
use Illuminate\Http\Request;

class AssambliesController extends Controller
{
    protected $module   = 'master.assamblies';
    protected $routes   = 'master.assamblies';
    protected $views    = 'master.assamblies';
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
                'title' => 'Assamblies',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Assamblies' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:code|label:Id Assamblies|className:text-left'),
                        $this->makeColumn('name:name|label:Nama Assamblies|className:text-left'),
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
        $records = Assamblies::with('statusAset','kondisiAset','tipeAset','lokasi','subLokasi')
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
        return $this->render(
            $this->views . '.create',
            compact(
                'STATUSASET',
                'KONDISIASET',
                'TIPEASET',
                'LOKASI',
                'SUBLOKASI'
                )
        );
    }

    public function store(AssambliesRequest $request)
    {
        $record = new Assamblies;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Assamblies $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Assamblies $record)
    {
        $STATUSASET  = StatusAset::orderBy('name', 'ASC')->get();
        $KONDISIASET = KondisiAset::orderBy('name', 'ASC')->get();
        $TIPEASET = TioeAset::orderBy('name', 'ASC')->get();
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

    public function update(AssambliesRequest $request, Assamblies $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Assamblies $record)
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
