<?php

namespace App\Http\Controllers\Setting\User;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\User\UserRequest;
use App\Models\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $module = 'setting_user';
    protected $routes = 'setting.user';
    protected $views = 'setting.user';
    protected $perms = 'setting';

    public function __construct()
    {
        $this->prepare([
            'module' => $this->module,
            'routes' => $this->routes,
            'views' => $this->views,
            'perms' => $this->perms,
            'permission' => $this->perms.'.view',
            'title' => 'Manajemen User',
            'breadcrumb' => [
                'Pengaturan Umum' => route($this->routes.'.index'),
                'Manajemen User' => route($this->routes.'.index'),
            ]
        ]);
    }

    public function index()
    {
        $this->prepare([
            'tableStruct' => [
                'datatable_1' => [
                    $this->makeColumn('name:num'),
                    $this->makeColumn('name:name|label:Nama|className:text-left'),
                    $this->makeColumn('name:username|label:Username|className:text-center'),
                    $this->makeColumn('name:email|label:Email|className:text-center'),
                    // $this->makeColumn('name:nik|label:NIK|className:text-center'),
                    $this->makeColumn('name:position|label:Jabatan|className:text-center'),
                    $this->makeColumn('name:role|label:Role|className:text-center'),
                    $this->makeColumn('name:status'),
                    $this->makeColumn('name:updated_by|label:Diperbarui|width:130px'),
                    $this->makeColumn('name:action'),
                ],
            ],
        ]);
        return $this->render($this->views.'.index');
    }

    public function grid()
    {
        $records = User::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn('num', function ($record) {
                return request()->start;
            })
            ->addColumn('position', function ($record) {
                return $record->position->name ?? '-';
            })
            ->addColumn('role', function ($record) {
                if ($record->roles()->exists()) {
                    return implode('<br>', $record->roles()->pluck('name')->toArray());
                }
                return '-';
            })
            ->editColumn('status', function ($record) {
                return $record->labelStatus();
            })
            ->editColumn('updated_by', function ($record) {
                return $record->createdByRaw();
            })
            ->addColumn('action', function ($record) {
                $actions = [];
                $actions[] = [
                    'type' => 'show',
                    'id' => $record->id
                ];
                $actions[] = [
                    'type' => 'edit',
                    'id' => $record->id,
                ];

                if ($record->canDeleted()) {
                    $actions[] = [
                        'type' => 'delete',
                        'id' => $record->id,
                        'attrs' => 'data-confirm-text="'.__('Hapus').' User '.$record->name.'?"',
                    ];
                }
                return $this->makeButtonDropdown($actions);
            })
            ->rawColumns(['action','updated_by','status','position'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views.'.create');
    }

    public function store(UserRequest $request)
    {
        $record = new User;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(User $record)
    {
        return $this->render($this->views.'.show', compact('record'));
    }

    public function edit(User $record)
    {
        return $this->render($this->views.'.edit', compact('record'));
    }

    public function update(UserRequest $request, User $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(User $record)
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
        $fileName = date('Y-m-d').' Template Import Data '. $this->prepared('title') .'.xlsx';
        $view = $this->views.'.template';
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
        
        $record = new User;
        return $record->handleImport($request);
    }
}
