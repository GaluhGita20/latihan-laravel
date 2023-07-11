<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\SubUnitRequest;
use App\Models\Master\SubUnit;
use Illuminate\Http\Request;

class SubUnitController extends Controller
{
    protected $module   = 'master.sub-unit';
    protected $routes   = 'master.sub-unit';
    protected $views    = 'master.sub-unit';
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
                'title' => 'Sub Unit',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Sub Unit' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:equipment_id|label:Equipment|className:text-center'),
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
        $records = SubUnit::grid()->filters()->dtGet();

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
                'equipment_id',
                function ($record) {
                    return '<span>'. $record->equipment->name .'</span>';
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
            ->rawColumns(['action', 'updated_by', 'description', 'equipment_id'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(SubUnitRequest $request)
    {
        $record = new SubUnit;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(SubUnit $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(SubUnit $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(SubUnitRequest $request, SubUnit $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(SubUnit $record)
    {
        return $record->handleDestroy();
    }
}
