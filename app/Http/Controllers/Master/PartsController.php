<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PartsRequest;
use App\Models\Master\Parts;
use App\Models\Master\KondisiAset;
use App\Models\Master\StatusAset;
use App\Models\Master\TipeAset;
use App\Models\Master\Lokasi;
use App\Models\Master\SubLokasi;
use App\Models\Master\Assemblies;
use Illuminate\Http\Request;

class PartsController extends Controller
{
    protected $module   = 'master.parts';
    protected $routes   = 'master.parts';
    protected $views    = 'master.parts';
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
                'title' => 'Parts',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Parts' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:komponen_id|label:Komponen|className:text-center'),
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
        $records = Parts::grid()->filters()->dtGet();

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
                'komponen_id',
                function ($record) {
                    return '<span>'. $record->komponen->name .'</span>';
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
            ->rawColumns(['action', 'updated_by', 'description', 'komponen_id'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(PartsRequest $request)
    {
        $record = new Parts;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Parts $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Parts $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(PartsRequest $request, Parts $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Parts $record)
    {
        return $record->handleDestroy();
    }
}
