<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\SubLokasiRequest;
use App\Models\Master\SubLokasi;
use App\Models\Master\Lokasi;
use Illuminate\Http\Request;

class SubLokasiController extends Controller
{
    protected $module   = 'master.sub-lokasi';
    protected $routes   = 'master.sub-lokasi';
    protected $views    = 'master.sub-lokasi';
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
                'title' => 'System',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'System' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:struct.name|label:Struktur|className:text-left'),
                        $this->makeColumn('name:lokasi.name|label:Lokasi|className:text-left'),
                        $this->makeColumn('name:name|label:Sub Lokasi|className:text-left'),
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
        $records = SubLokasi::with('lokasi','struct')
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
        $LOKASI = Lokasi::orderBy('name', 'ASC')->get();
        return $this->render(
            $this->views . '.create',
            compact('LOKASI')
        );
    }

    public function store(SubLokasiRequest $request)
    {
        $record = new SubLokasi;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(SubLokasi $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(SubLokasi $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(SubLokasiRequest $request, SubLokasi $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(SubLokasi $record)
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

        $record = new SubLokasi;
        return $record->handleImport($request);
    }
}
