<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\VendorAsetRequest;
use App\Models\Master\VendorAset;
use App\Models\Master\Geo\City;
use App\Models\Master\Geo\Province;
use Illuminate\Http\Request;

class VendorAsetController extends Controller
{
    protected $module   = 'master.vendor-aset';
    protected $routes   = 'master.vendor-aset';
    protected $views    = 'master.vendor-aset';
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
                'title' => 'Vendor',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Vendor' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:code|label:Id Vendor|className:text-left'),
                        $this->makeColumn('name:name|label:Nama Vendor|className:text-left'),
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
        $records = VendorAset::with('city.province')
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

    public function store(VendorAsetRequest $request)
    {
        $record = new VendorAset;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(VendorAset $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(VendorAset $record)
    {
        $PROVINCES  = Province::orderBy('name', 'ASC')->get();
        $CITIES     = City::where('province_id', $record->city->province_id)
            ->orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.edit',
            compact(
                'record',
                'PROVINCES',
                'CITIES'
            )
        );
    }

    public function update(VendorAsetRequest $request, VendorAset $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(VendorAset $record)
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
