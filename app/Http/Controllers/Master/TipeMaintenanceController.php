<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\TipeMaintenanceRequest;
use App\Models\Master\TipeMaintenance;
use Illuminate\Http\Request;

class TipeMaintenanceController extends Controller
{
    protected $module   = 'master.tipe-maintenance';
    protected $routes   = 'master.tipe-maintenance';
    protected $views    = 'master.tipe-maintenance';
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
                'title' => 'Tipe Pemeliharaan',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Tipe Pemeliharaan' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:name|label:Tipe Pemeliharaan|className:text-left'),
                        $this->makeColumn('name:description|label:Deskripsi|className:text-center'),
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
        $records = TipeMaintenance::grid()->filters()->dtGet();

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
            ->rawColumns(['action', 'updated_by', 'description'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(TipeMaintenanceRequest $request)
    {
        $record = new TipeMaintenance;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(TipeMaintenance $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(TipeMaintenance $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(TipeMaintenanceRequest $request, TipeMaintenance $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(TipeMaintenance $record)
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
