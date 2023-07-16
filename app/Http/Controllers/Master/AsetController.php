<?php

namespace App\Http\Controllers\Master;

use App\Exports\GenerateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AsetRequest;
use App\Models\Master\Aset;
use App\Models\Master\KondisiAset;
use App\Models\Master\StatusAset;
use App\Models\Master\TipeAset;
use App\Models\Master\Lokasi;
use App\Models\Master\SubLokasi;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    protected $module   = 'master.aset';
    protected $routes   = 'master.aset';
    protected $views    = 'master.aset';
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
                'title' => 'Aset',
                'breadcrumb' => [
                    'Data Master' => route($this->routes . '.index'),
                    'Aset' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:id_aset|label:Id Aset|className:text-center'),
                        $this->makeColumn('name:name|label:Nama Aset|className:text-center'),
                        $this->makeColumn('name:struktur_aset|label:Struktur Aset|className:text-center'),
                        $this->makeColumn('name:harga_per_unit|label:Harga Per Unit|className:text-center'),
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
        $records = Aset::grid()
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
                'harga_per_unit',
                function ($record) {
                    return 'Rp. '.$record->harga_per_unit;
                }
            )
            ->addColumn(
                'struktur_aset',
                function ($record) {
                    return ucfirst($record->struktur_aset);
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
        return $this->render($this->views . '.create');
    }

    public function store(AsetRequest $request)
    {
        $record = new Aset;
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Aset $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Aset $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(AsetRequest $request, Aset $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(Aset $record)
    {
        return $record->handleDestroy();
    }
}
