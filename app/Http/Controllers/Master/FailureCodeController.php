<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\FailureCodeRequest;
use App\Models\Master\FailureCode;
use App\Models\Master\Geo\Province;
use Illuminate\Http\Request;

class FailureCodeController extends Controller
{
    protected $module   = 'master.failure-code';
    protected $routes   = 'master.failure-code';
    protected $views    = 'master.failure-code';
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
                'title' => 'Failure Code',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Failure Code' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:province.name|label:Id Aset|className:text-left'),
                        $this->makeColumn('name:name|label:Failure Code|className:text-left'),
                        $this->makeColumn('name:desc|label:Deskripsi|className:text-left'),
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
        $records = FailureCode::with('province')
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
        $PROVINCES = Province::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.create',
            compact('PROVINCES')
        );
    }

    public function store(FailureCodeRequest $request)
    {
        $record = new FailureCode;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(FailureCode $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(FailureCode $record)
    {
        $PROVINCES = Province::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.edit',
            compact('record', 'PROVINCES')
        );
    }

    public function update(FailureCodeRequest $request, FailureCode $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(FailureCode $record)
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
