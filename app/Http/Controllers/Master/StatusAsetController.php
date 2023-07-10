<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StatusAsetRequest;
use App\Models\Master\StatusAset;
use Illuminate\Http\Request;

class StatusAsetController extends Controller
{
    protected $module   = 'master.status-aset';
    protected $routes   = 'master.status-aset';
    protected $views    = 'master.status-aset';
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
                'title' => 'Status Aset',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Status Aset' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:updated_by|label:Diperbarui|width:130px'),
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
        $records = StatusAset::grid()->filters()->dtGet();

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

    public function store(StatusAsetRequest $request)
    {
        $record = new StatusAset;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(StatusAset $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(StatusAset $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(StatusAsetRequest $request, StatusAset $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(StatusAset $record)
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
