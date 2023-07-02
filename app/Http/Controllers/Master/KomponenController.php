<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\KomponenRequest;
use App\Models\Master\Komponen;
use Illuminate\Http\Request;

class KomponenController extends Controller
{
    protected $module   = 'master.komponen';
    protected $routes   = 'master.komponen';
    protected $views    = 'master.komponen';
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
                'title' => 'Komponen',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Komponen' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:sub_unit_id|label:Sub Unit|className:text-center'),
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
        $records = Komponen::grid()->filters()->dtGet();

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
                'sub_unit_id',
                function ($record) {
                    return '<span>'. $record->subUnit->name .'</span>';
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
            ->rawColumns(['action', 'updated_by', 'description', 'sub_unit_id'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(KomponenRequest $request)
    {
        $record = new Komponen;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Komponen $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Komponen $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(KomponenRequest $request, Komponen $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Komponen $record)
    {
        return $record->handleDestroy();
    }
}
