<?php

namespace App\Http\Controllers\Master\Pendidikan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Pendidikan\PendidikanRequest;
use App\Models\Master\Pendidikan\Pendidikan;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    protected $module   = 'master.pendidikan.pendidikan'; //config
    protected $routes   = 'master.pendidikan.pendidikan'; //web.php
    protected $views    = 'master.pendidikan.pendidikan'; //folder resources
    protected $perms    = 'master';

    public function __construct()
    {
        $this->prepare([
            'module' => $this->module,
            'routes' => $this->routes,
            'views' => $this->views,
            'perms' => $this->perms,
            'permission' => $this->perms.'.view',
            'title' => 'Pendidikan',
            'breadcrumb' => [
                'Data Master' => route($this->routes . '.index'),
                'Pendidikan' => route($this->routes . '.index'),
                'Pendidikan' => route($this->routes.'.index'),
            ]
        ]);
    }

    public function index()
    {
        $this->prepare([
            'tableStruct' => [
                'datatable_1' => [
                    $this->makeColumn('name:num'),
                    $this->makeColumn('name:name|label:Nama|className:text-center'),
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
        $records = Pendidikan::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn('num', function ($record) {
                return request()->start;
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

    public function store(PendidikanRequest $request)
    {
        $record = new Pendidikan;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Pendidikan $record)
    {
        return $this->render($this->views.'.show', compact('record'));
    }

    public function edit(Pendidikan $record)
    {
        return $this->render($this->views.'.edit', compact('record'));
    }

    public function update(PendidikanRequest $request, Pendidikan $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Pendidikan $record)
    {
        return $record->handleDestroy();
    }
}
