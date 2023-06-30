<?php

namespace App\Http\Controllers\Purchasing\PurchaseOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Purchasing\PurchaseOrder\PurchaseOrder;
use App\Models\Purchasing\PurchaseOrder\PurchaseOrderDetail;
use App\Http\Requests\Purchasing\PurchaseOrder\PurchaseOrderRequest;
use App\Http\Requests\Purchasing\PurchaseOrder\PurchaseOrderDetailRequest;

class PurchaseOrderController extends Controller
{
    protected $module = 'purchasing.purchase-order';
    protected $routes = 'purchasing.purchase-order';
    protected $views = 'purchasing.purchase-order';
    protected $perms = 'purchasing.purchase-order';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Purchase Order',
                'breadcrumb' => [
                    'Purchasing' => route($this->routes . '.index'),
                    'Purchase Order' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:id_purchase_order|label:ID Purchase Order|className:text-center'),
                        $this->makeColumn('name:tgl_purchase_order|label:Tgl Purchase Order|className:text-center'),
                        $this->makeColumn('name:tgl_kirim|label:Tgl Kirim|className:text-center'),
                        $this->makeColumn('name:vendor_id|label:Vendor|className:text-center'),
                        $this->makeColumn('name:item|label:Item|className:text-center'),
                        $this->makeColumn('name:status'),
                        $this->makeColumn('name:updated_by'),
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
        $records = PurchaseOrder::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function () {
                    return request()->start;
                }
            )
            ->addColumn(
                'id_purchase_order',
                function ($records) use ($user) {
                    return '<span class="badge badge-danger">' . $records->id_purchase_order . '</span>';
                }
            )
            ->addColumn(
                'tgl_purchase_order',
                function ($records) use ($user) {
                    return '<span class="badge badge-warning">' . $records->tgl_purchase_order->format('d/m/Y') . '</span>';
                }
            )
            ->addColumn(
                'tgl_kirim',
                function ($records) use ($user) {
                    return '<span class="badge badge-warning">' . $records->tgl_kirim->format('d/m/Y') . '</span>';
                }
            )
            ->addColumn(
                'vendor_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-primary">' . $records->vendor->name ?? '' . '</span>';
                }
            )
            ->addColumn(
                'item',
                function ($records) use ($user) {
                    if (!empty($records->detail)) {
                        return '<span class="badge badge-info">' . $records->detail->count() . ' Item</span>';
                    }
                    return '';
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
                    // if ($records->checkAction('print', $this->perms)) {
                    //     $actions[] = 'type:print';
                    // }

                    return $this->makeButtonDropdown($actions, $records->id);
                }
            )
            ->rawColumns(
                [
                    'id_purchase_order',
                    'tgl_purchase_order',
                    'tgl_kirim',
                    'vendor_id',
                    'item',
                    'status',
                    'updated_by',
                    'action',
                ]
            )
            ->make(true);
    }

    public function detail(PurchaseOrder $record)
    {
        $this->prepare(
            [
                'tableStruct2' => [
                    'url' => route($this->routes . '.detailPurchaseGrid', $record->id),
                    'datatable_2' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:barang_id|label:Barang|className:text-center|width:300px'),
                        $this->makeColumn('name:jumlah|label:Jumlah|className:text-center|width:300px'),
                        $this->makeColumn('name:harga_per_unit|label:Harga Per Unit|className:text-center|width:300px'),
                        $this->makeColumn('name:total_harga|label:Total Harga|className:text-center|width:300px'),
                        $this->makeColumn('name:updated_by'),
                        $this->makeColumn('name:action'),
                    ]
                ],
            ]
        );

        return $this->render($this->views . '.detail.index', compact('record'));
    }

    public function detailShow(PurchaseOrder $record)
    {
        $this->prepare(
            [
                'tableStruct2' => [
                    'url' => route($this->routes . '.detailPurchaseGridShow', $record->id),
                    'datatable_2' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:barang_id|label:Barang|className:text-center|width:300px'),
                        $this->makeColumn('name:jumlah|label:Jumlah|className:text-center|width:300px'),
                        $this->makeColumn('name:harga_per_unit|label:Harga Per Unit|className:text-center|width:300px'),
                        $this->makeColumn('name:total_harga|label:Total Harga|className:text-center|width:300px'),
                        $this->makeColumn('name:updated_by'),
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

    public function store(PurchaseOrderRequest $request, PurchaseOrder $detail)
    {
        return $detail->handleStoreOrUpdate($request);
    }

    public function show(PurchaseOrder $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function edit(PurchaseOrder $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(PurchaseOrderRequest $request, PurchaseOrder $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function submit(PurchaseOrder $record)
    {
        $flowApproval = $record->getFlowApproval($this->module);
        return $this->render($this->views . '.submit', compact('record', 'flowApproval'));
    }

    public function submitSave(PurchaseOrder $record, Request $request)
    {
        return $record->handleSubmitSave($request);
    }

    public function reject(PurchaseOrder $record, Request $request)
    {
        $request->validate(['note' => 'required|string|max:65500']);
        return $record->handleReject($request);
    }

    public function approval(PurchaseOrder $record)
    {
        $this->prepare(
            [
                'tableStruct2' => [
                    'url' => route($this->routes . '.detailPurchaseGridShow', $record->id),
                    'datatable_2' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:barang_id|label:Barang|className:text-center|width:300px'),
                        $this->makeColumn('name:jumlah|label:Jumlah|className:text-center|width:300px'),
                        $this->makeColumn('name:harga_per_unit|label:Harga Per Unit|className:text-center|width:300px'),
                        $this->makeColumn('name:total_harga|label:Total Harga|className:text-center|width:300px'),
                        $this->makeColumn('name:updated_by'),
                        $this->makeColumn('name:action'),
                    ]
                ],
            ]
        );

        return $this->render($this->views . '.approval', compact('record'));
    }

    public function approve(PurchaseOrder $record, Request $request)
    {
        return $record->handleApprove($request);
    }

    public function history(PurchaseOrder $record)
    {
        $this->prepare(['title' => 'History Aktivitas']);
        return $this->render('globals.history', compact('record'));
    }

    public function tracking(PurchaseOrder $record)
    {
        $this->prepare(['title' => 'Tracking Approval']);
        return $this->render('globals.tracking', compact('record'));
    }

    public function print(PurchaseOrder $record)
    {
        $title = $this->prepared('title') . ' ' . date_format(date_create($record->created_at), 'Y');
        $module = $this->prepared('module');
        $pdf = \PDF::loadView($this->views . '.print', compact('title', 'module', 'record'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream(date('Y-m-d') . ' ' . $title . '.pdf');
    }

    public function destroy(PurchaseOrder $record)
    {
        return $record->handleDestroy();
    }

    public function detailPurchaseGrid(PurchaseOrder $record)
    {
        $user = auth()->user();
        $records = PurchaseOrderDetail::grid()
            ->whereHas(
                'purchaseOrder',
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
                'barang_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-primary">' . $records->barang->name . '</span>';
                }
            )
            ->addColumn(
                'jumlah',
                function ($records) use ($user) {
                    return '<span class="badge badge-warning">' . $records->jumlah . ' Item</span>';
                }
            )
            ->addColumn(
                'harga_per_unit',
                function ($records) use ($user) {
                    return '<span class="badge badge-info">Rp. ' . $records->harga_per_unit . '</span>';
                }
            )
            ->addColumn(
                'total_harga',
                function ($records) use ($user) {
                    return '<span class="badge badge-danger">Rp. ' . $records->total_harga . '</span>';
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
                        'url' => route($this->routes . '.detailPurchaseShow', $records->id),
                    ];
                    $actions[] = [
                        'type' => 'edit',
                        'attrs' => 'data-modal-size="modal-md"',
                        'url' => route($this->routes . '.detailPurchaseEdit', $records->id),
                    ];
                    $actions[] = [
                        'type' => 'delete',
                        'url' => route($this->routes . '.detailPurchaseDestroy', $records->id),
                        'text' => $records->sub_sasaran,
                    ];

                    return $this->makeButtonDropdown($actions, $records->id);
                }
            )
            ->rawColumns(['action', 'barang_id', 'jumlah', 'harga_per_unit', 'updated_by', 'total_harga'])
            ->make(true);
    }

    public function detailPurchaseGridShow(PurchaseOrder $record)
    {
        $user = auth()->user();
        $records = PurchaseOrderDetail::grid()
            ->whereHas(
                'purchaseOrder',
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
                'barang_id',
                function ($records) use ($user) {
                    return '<span class="badge badge-primary">' . $records->barang->name . '</span>';
                }
            )
            ->addColumn(
                'jumlah',
                function ($records) use ($user) {
                    return '<span class="badge badge-warning">' . $records->jumlah . ' Item</span>';
                }
            )
            ->addColumn(
                'harga_per_unit',
                function ($records) use ($user) {
                    return '<span class="badge badge-info">Rp. ' . $records->harga_per_unit . '</span>';
                }
            )
            ->addColumn(
                'total_harga',
                function ($records) use ($user) {
                    return '<span class="badge badge-danger">Rp. ' . $records->total_harga . '</span>';
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
                        'url' => route($this->routes . '.detailPurchaseShow', $records->id),
                    ];


                    return $this->makeButtonDropdown($actions, $records->id);
                }
            )
            ->rawColumns(['action', 'barang_id', 'jumlah', 'harga_per_unit', 'updated_by', 'total_harga'])
            ->make(true);
    }


    public function detailPurchase(PurchaseOrder $detail)
    {
        $this->prepare(
            [
                'title' => 'Detail Purchase Order'
            ]
        );
        return $this->render($this->views . '.detail.create', compact('detail'));
    }

    public function detailPurchaseShow(PurchaseOrderDetail $detail)
    {
        $this->prepare(
            [
                'title' => 'Detail Purchase Order'
            ]
        );
        $record = $detail->perencanaan;
        return $this->render($this->views . '.detail.show', compact('record', 'detail'));
    }

    public function detailPurchaseEdit(PurchaseOrderDetail $detail)
    {
        $this->prepare(
            [
                'title' => 'Detail Purchase Order'
            ]
        );
        $record = $detail->perencanaan;
        return $this->render($this->views . '.detail.edit', compact('record', 'detail'));
    }

    public function detailPurchaseStore(PurchaseOrderDetailRequest $request, PurchaseOrderDetail $detail)
    {
        return $detail->handleDetailPurchaseStoreOrUpdate($request);
    }

    public function detailPurchaseUpdate(PurchaseOrderDetailRequest $request, PurchaseOrderDetail $detail)
    {
        return $detail->handleDetailPurchaseStoreOrUpdate($request);
    }

    public function detailPurchaseDestroy(PurchaseOrderDetail $detail)
    {
        return $detail->handleDetailPurchaseDestroy($detail);
    }
}
