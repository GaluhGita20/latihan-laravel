<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\LokasiRequest;
use App\Models\Master\Lokasi;
use App\Models\Master\Geo\Province;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    protected $module   = 'master.lokasi';
    protected $routes   = 'master.lokasi';
    protected $views    = 'master.lokasi';
    protected $perms    = 'master';

    public function __construct()
    {
        $this->prepare([
            'module' => $this->module,
            'routes' => $this->routes,
            'views' => $this->views,
            'perms' => $this->perms,
            'permission' => $this->perms.'.view',
            'title' => 'Lokasi',
            'breadcrumb' => [
                'Data Master' => route($this->routes . '.index'),
                'Lokasi' => route($this->routes.'.index'),
            ]
        ]);
    }

    public function index()
    {
        $this->prepare([
            'tableStruct' => [
                'datatable_1' => [
                    $this->makeColumn('name:num'),
                    $this->makeColumn('name:struct.name|label:Struktur|className:text-left'),
                    $this->makeColumn('name:name|label:Lokasi|className:text-center'),
                    $this->makeColumn('name:updated_by|label:Diperbarui|width:130px'),
                    $this->makeColumn('name:action'),
                ],
            ],
        ]);
        return $this->render($this->views.'.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = Lokasi::with('struct')->grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn('num', function ($record) {
                return request()->start;
            })
            ->addColumn('location', function ($record) {
                return $record->location->name ?? '';
            })
            ->addColumn('updated_by', function ($record) {
                return $record->createdByRaw();
            })
            ->addColumn('action', function ($record) use ($user) {
                $actions = [
                    'type:show|id:'.$record->id,
                    'type:edit|id:'.$record->id,
                ];
                if ($record->canDeleted()) {
                    $actions[] = [
                        'type' => 'delete',
                        'id' => $record->id,
                        'attrs' => 'data-confirm-text="'.__('Hapus').' '.$record->name.'?"',
                    ];
                }
                return $this->makeButtonDropdown($actions);
            })
            ->rawColumns(['action','updated_by','location'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views.'.create');
    }

    public function store(LokasiRequest $request)
    {
        $record = new Lokasi;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Lokasi $record)
    {
        return $this->render($this->views.'.show', compact('record'));
    }

    public function edit(Lokasi $record)
    {
        return $this->render($this->views.'.edit', compact('record'));
    }

    public function update(LokasiRequest $request, Lokasi $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Lokasi $record)
    {
        return $record->handleDestroy();
    }

    public function import()
    {
        if (request()->get('download') == 'template') {
            return $this->template();
        }
        return $this->render($this->views.'.import');
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
        $request->validate([
            'uploads.uploaded' => 'required',
            'uploads.temp_files_ids.*' => 'required',
        ],[],[
            'uploads.uploaded' => 'File',
            'uploads.temp_files_ids.*' => 'File',
        ]);

        $record = new Position;
        return $record->handleImport($request);
    }
}
