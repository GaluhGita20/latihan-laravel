<?php

namespace App\Http\Controllers\RencanaPemeliharaan\Jadwal;

use App\Http\Controllers\Controller;
use App\Models\RencanaPemeliharaan\Jadwal\Jadwal;
use App\Models\RencanaPemeliharaan\Jadwal\DetailJadwal;
use App\Http\Requests\RencanaPemeliharaan\Jadwal\JadwalRequest;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    protected $module = 'rencana-pemeliharaan.jadwal';
    protected $routes = 'rencana-pemeliharaan.jadwal';
    protected $views = 'rencana-pemeliharaan.jadwal';
    protected $perms = 'rencana-pemeliharaan.jadwal';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Jadwal',
                'breadcrumb' => [
                    'Rencana Pemeliharaan' => route($this->routes . '.index'),
                    'Jadwal' => route($this->routes . '.index'),
                ],
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
                        $this->makeColumn('name:year|label:Tahun|className:text-center'),
                        $this->makeColumn('name:unit_kerja_id|label:Unit Kerja|className:text-center'),
                        $this->makeColumn('name:location_id|label:Lokasi|className:text-center'),
                        $this->makeColumn('name:sub_location_id|label:Sub Lokasi|className:text-center'),
                        $this->makeColumn('name:aset_id|label:Aset|className:text-center'),
                        $this->makeColumn('name:uraian|label:Uraian|className:text-center'),
                        $this->makeColumn('name:status'),
                        $this->makeColumn('name:updated_by|label:Diperbarui'),
                        $this->makeColumn('name:action'),
                    ]
                ]
            ]
        );

        return $this->render($this->views . '.index');
    }

    public function grid()
    {
        $user = auth()->user();
        $records = Jadwal::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function () {
                    return request()->start;
                }
            )
            ->addColumn(
                'year',
                function ($records) use ($user) {
                    return $records->year;
                }
            )
            ->addColumn(
                'location_id', 
                function ($record) {
                    return $record->location->name ?? '';
                }
            )
            ->addColumn(
                'aset_id', 
                function ($record) use ($user) {
                    return $record->aset->name ?? '';
                }
            )
            ->addColumn(
                'sub_location_id', 
                function ($record) use ($user) {
                    return $record->subLocation->lokasi->name ?? '';
                }
            )
            ->addColumn(
                'status',
                function ($records) use ($user) {
                    return $records->labelStatus($records->status ?? 'new');
                }
            )
            ->editColumn(
                'updated_by',
                function ($records) use ($user) {
                    if ($records->status == 'new' || empty($records->status)) {
                        return '';
                    } else {
                        return $records->createdByRaw();
                    }
                }
            )
            ->addColumn(
                'action',
                function ($records) use ($user) {
                    $actions = [];
                    if ($records->checkAction('show', $this->perms)) {
                        $actions[] = [
                            'type' => 'show',
                            'label' => 'Lihat',
                            'page' => true,
                            'url' => route($this->routes . '.detail.show', $records->id),
                        ];
                    }
                    if ($records->checkAction('edit', $this->perms)) {
                        $actions[] = [
                            'type' => 'edit',
                            'label' => 'Detail',
                            'icon'  => 'fa fa-plus text-primary',
                            'page' => true,
                            'url' => route($this->routes . '.detail', $records->id),
                        ];
                        $actions[] = [
                            'type' => 'edit',
                        ];
                    }
                    if ($records->checkAction('delete', $this->perms)) {
                        $actions[] = 'type:delete';
                    }
                    if ($records->checkAction('approval', $this->perms)) {
                        $actions[] = 'type:approval|page:true';
                    }
                    if ($records->checkAction('tracking', $this->perms)) {
                        $actions[] = 'type:tracking';
                    }
                    if ($records->checkAction('history', $this->perms)) {
                        $actions[] = 'type:history';
                    }

                    return $this->makeButtonDropdown($actions, $records->id);
                }
            )
            ->rawColumns(
                [
                    'tahun',
                    'unit_kerja_id',
                    'location_id',
                    'sub_location_id',
                    'aset_id',
                    'status',
                    'updated_by',
                    'action',
                ]
            )
            ->make(true);
    }

    public function detail(Jadwal $record)
    {
        $this->prepare(
            [
                'tableStruct2' => [
                    'url' => route($this->routes . '.detailJadwalGrid', $record->id),
                    'datatable_2' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:date|label:Bulan|className:text-center|width:300px'),
                        $this->makeColumn('name:tipe_pemeliharaan_id|label:Tipe Pemeliharaan|className:text-center|width:300px'),
                        $this->makeColumn('name:item_pemeliharaan_id|label:Item Pemeliharaan|className:text-center|width:300px'),
                        $this->makeColumn('name:jadwal_id|label:Jadwal|className:text-center|width:300px'),
                        $this->makeColumn('name:updated_by|label:Diperbarui'),
                        $this->makeColumn('name:action'),
                    ]
                ],
            ]
        );

        return $this->render($this->views . '.detail.index', compact('record'));
    }

    public function detailShow(Jadwal $record)
    {
        $this->prepare(
            [
                'tableStruct2' => [
                    'url' => route($this->routes . '.detailJadwalGrid', $record->id),
                    'datatable_2' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:date|label:Bulan|className:text-center|width:300px'),
                        $this->makeColumn('name:tipe_pemeliharaan_id|label:Tipe Pemeliharaan|className:text-center|width:300px'),
                        $this->makeColumn('name:item_pemeliharaan_id|label:Item Pemeliharaan|className:text-center|width:300px'),
                        $this->makeColumn('name:jadwal_id|label:Jadwal|className:text-center|width:300px'),
                        $this->makeColumn('name:updated_by|label:Diperbarui'),
                        $this->makeColumn('name:action'),
                    ]
                ],
            ]
        );

        return $this->render($this->views . '.detail.index', compact('record'));
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(JadwalRequest $request, Jadwal $detail)
    {
        return $detail->handleStoreOrUpdate($request);
    }

    public function show(Jadwal $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(Jadwal $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(Request $request, Jadwal $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function submit(Jadwal $record)
    {
        $flowApproval = $record->getFlowApproval($this->module);
        return $this->render($this->views . '.submit', compact('record', 'flowApproval'));
    }

    public function submitSave(Jadwal $record, Request $request)
    {
        return $record->handleSubmitSave($request);
    }

    public function reject(Jadwal $record, Request $request)
    {
        $request->validate(['note' => 'required|string|max:65500']);
        return $record->handleReject($request);
    }

    public function approval(Jadwal $record)
    {
        $this->prepare(
            [
                'tableStruct2' => [
                    'url' => route($this->routes . '.detailJadwalGridShow', $record->id),
                    'datatable_2' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:date|label:Bulan|className:text-center|width:300px'),
                        $this->makeColumn('name:tipe_pemeliharaan_id|label:Tipe Pemeliharaan|className:text-center|width:300px'),
                        $this->makeColumn('name:item_pemeliharaan_id|label:Item Pemeliharaan|className:text-center|width:300px'),
                        $this->makeColumn('name:jadwal_id|label:Jadwal|className:text-center|width:300px'),
                        $this->makeColumn('name:updated_by|label:Diperbarui'),
                        $this->makeColumn('name:action'),
                    ]
                ],
            ]
        );

        return $this->render($this->views . '.approval', compact('record'));
    }

    public function approve(Jadwal $record, Request $request)
    {
        return $record->handleApprove($request);
    }

    public function history(Jadwal $record)
    {
        $this->prepare(['title' => 'History Aktivitas']);
        return $this->render('globals.history', compact('record'));
    }

    public function tracking(Jadwal $record)
    {
        $this->prepare(['title' => 'Tracking Approval']);
        return $this->render('globals.tracking', compact('record'));
    }

    public function destroy(Jadwal $record)
    {
        return $record->handleDestroy();
    }

    public function detailJadwalGrid(Jadwal $record)
    {
        $user = auth()->user();
        $records = DetailJadwal::grid()
            ->whereHas(
                'jadwal',
                function ($q) use ($record) {
                    $q->where('id', $record->id);
                }
            )
            ->filters()
            ->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($detail) {
                    return request()->start;
                }
            )
            ->addColumn(
                'date',
                function ($records) {
                    return '<span class="badge badge-danger">' . $record->bulan->format('d/m/Y') . ' Words</span>';
                }
            )
            ->addColumn(
                'tipe_pemeliharaan_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-info">' . $records->tipePemeliharaan->name . '</span>';
                }
            )
            ->addColumn(
                'item_pemeliharaan_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-info">' . $records->itemPemeliharaan->name . '</span>';
                }
            )
            ->addColumn(
                'jadwal_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-info">' . $records->jadwal->jadwal_id . '</span>';
                }
            )
            ->addColumn(
                'updated_by',
                function ($detail) use ($user) {
                    return '<div data-order="' . ($detail->updated_at ?: ($detail->updated_at ?: $detail->created_at)) . '" class="text-left make-td-py-0">
                        <small>
                            <div class="text-nowrap">
                                <i data-toggle="tooltip" title="' . \Str::title($detail->detailCreatorName()) . '"
                                    class="fa fa-user fa-fw fa-lg mr-2"></i>
                                ' . \Str::title($detail->detailCreatorName()) . '
                            </div>
                            <div class="text-nowrap">
                                <i data-toggle="tooltip" title="' . (($detail->updated_at ?: $detail->updated_at) ?? $detail->created_at)->format('d M Y, H:i') . '"
                                    class="fa fa-clock fa-fw fa-lg mr-2"></i>
                                ' . $detail->detailCreationDate() . '
                            </div>
                        </small>
                    </div>';
                }
            )
            ->addColumn(
                'action',
                function ($records) use ($user) {
                    $actions = [];
                    $actions[] = [
                        'type' => 'show',
                        'attrs' => 'data-modal-size="modal-md"',
                        'url' => route($this->routes . '.detailJadwalShow', $records->id),
                    ];
                    $actions[] = [
                        'type' => 'edit',
                        'attrs' => 'data-modal-size="modal-md"',
                        'url' => route($this->routes . '.detailJadwalEdit', $records->id),
                    ];
                    $actions[] = [
                        'type' => 'delete',
                        'url' => route($this->routes . '.detailJadwalDestroy', $records->id),
                        'text' => $records->sub_sasaran,
                    ];
                
                    return $this->makeButtonDropdown($actions, $records->id);
                }
            )
            ->rawColumns(['action', 'tipe_pemeliharaan_id', 'item_pemeliharaan_id', 'date', 'updated_by'])
            ->make(true);
    }

    public function detailJadwalGridShow(Jadwal $record)
    {
        $user = auth()->user();
        $records = DetailJadwal::grid()
            ->whereHas(
                'jadwal',
                function ($q) use ($record) {
                    $q->where('id', $record->id);
                }
            )
            ->filters()
            ->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($detail) {
                    return request()->start;
                }
            )
            ->addColumn(
                'date',
                function ($records) {
                    return '<span class="badge badge-danger">' . $record->bulan->format('d/m/Y') . ' Words</span>';
                }
            )
            ->addColumn(
                'tipe_pemeliharaan_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-info">' . $records->tipePemeliharaan->name . '</span>';
                }
            )
            ->addColumn(
                'item_pemeliharaan_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-info">' . $records->itemPemeliharaan->name . '</span>';
                }
            )
            ->addColumn(
                'jadwal_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-info">' . $records->jadwal->jadwal_id . '</span>';
                }
            )
            ->addColumn(
                'updated_by',
                function ($detail) use ($user) {
                    return '<div data-order="' . ($detail->updated_at ?: ($detail->updated_at ?: $detail->created_at)) . '" class="text-left make-td-py-0">
                        <small>
                            <div class="text-nowrap">
                                <i data-toggle="tooltip" title="' . \Str::title($detail->detailCreatorName()) . '"
                                    class="fa fa-user fa-fw fa-lg mr-2"></i>
                                ' . \Str::title($detail->detailCreatorName()) . '
                            </div>
                            <div class="text-nowrap">
                                <i data-toggle="tooltip" title="' . (($detail->updated_at ?: $detail->updated_at) ?? $detail->created_at)->format('d M Y, H:i') . '"
                                    class="fa fa-clock fa-fw fa-lg mr-2"></i>
                                ' . $detail->detailCreationDate() . '
                            </div>
                        </small>
                    </div>';
                }
            )
            ->addColumn(
                'action',
                function ($records) use ($user) {
                    $actions = [];
                        $actions[] = [
                            'type' => 'show',
                            'attrs' => 'data-modal-size="modal-md"',
                            'url' => route($this->routes . '.detailJadwalShow', $records->id),
                        ];
                    
                    
                    return $this->makeButtonDropdown($actions, $records->id);
                }
            )
            ->rawColumns(['action', 'tipe_pemeliharaan_id', 'item_pemeliharaan_id', 'date', 'updated_by'])
            ->make(true);
    }


    public function detailJadwal(Jadwal $detail)
    {
        $this->prepare(
            [
                'title' => 'Detail Jadwal'
            ]
        );
        return $this->render($this->views . '.detail.create', compact('detail'));
    }

    public function detailJadwalShow(DetailJadwal $detail)
    {
        $record = $detail->jadwal;
        return $this->render($this->views . '.detail.show', compact('record', 'detail'));
    }

    public function detailJadwalEdit(DetailJadwal $detail)
    {
        return $this->render($this->views . '.detail.edit', compact('detail'));
    }

    public function detailJadwalStore(Request $request, DetailJadwal $detail)
    {
        return $detail->handleStoreOrUpdate($request);
    }

    public function detailJadwalUpdate(Request $request, DetailJadwal $detail)
    {
        return $detail->handleStoreOrUpdate($request);
    }

    public function detailJadwalDestroy(DetailJadwal $detail)
    {
        return $detail->handleDetailJadwalDestroy($detail);
    }
}
