<?php

namespace App\Http\Controllers\Example\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Example\Crud\CrudRequest;
use App\Models\Example\Crud\Crud;
use App\Models\Master\Example\Example;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    protected $module   = 'example.crud';
    protected $routes   = 'example.crud';
    protected $views    = 'example.crud';
    protected $perms    = 'example.crud';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Crud',
                'breadcrumb' => [
                    'Crud' => route($this->routes . '.index'),
                    'Crud' => route($this->routes . '.index'),
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
                        $this->makeColumn('name:year|label:Tahun|className:text-center'),
                        $this->makeColumn('name:date|label:Tanggal|className:text-center'),
                        $this->makeColumn('name:range|label:Rentang Tanggal|className:text-center'),
                        $this->makeColumn('name:input|label:Input|className:text-left'),
                        $this->makeColumn('name:status'),
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
        $records = Crud::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn(
                'num',
                function ($record) {
                    return request()->start;
                }
            )
            ->addColumn(
                'date',
                function ($record) {
                    return $record->show_date;
                }
            )
            ->addColumn(
                'range',
                function ($record) {
                    return $record->show_range_start . ' - ' . $record->show_range_end;
                }
            )
            ->addColumn(
                'status',
                function ($record) use ($user) {
                    return $record->labelStatus($record->status ?? 'new');
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
                    $actions = [];
                    if ($record->checkAction('show', $this->perms)) {
                        $actions[] = 'type:show|page:true';
                    }
                    if ($record->checkAction('edit', $this->perms)) {
                        $actions[] = 'type:edit|page:true';
                    }
                    if ($record->checkAction('delete', $this->perms)) {
                        $actions[] = 'type:delete';
                    }
                    if ($record->checkAction('approval', $this->perms)) {
                        $actions[] = 'type:approval|page:true';
                    }
                    if ($record->checkAction('tracking', $this->perms)) {
                        $actions[] = 'type:tracking';
                    }
                    if ($record->checkAction('print', $this->perms)) {
                        $actions[] = 'type:print';
                    }
                    if ($record->checkAction('history', $this->perms)) {
                        $actions[] = 'type:history';
                    }

                    return $this->makeButtonDropdown($actions, $record->id);
                }
            )
            ->rawColumns(['action', 'updated_by', 'status'])
            ->make(true);
    }

    public function create()
    {
        $options = (new Crud)->getOption('all');
        $examples = Example::get();
        return $this->render($this->views . '.create', compact('options', 'examples'));
    }

    public function store(Request $request)
    {
        dd($request->attachments);
        $record = new Crud;
        return $record->handleStoreOrUpdate($request);
    }

    public function edit(Crud $record)
    {
        $options = (new Crud)->getOption('all');
        $examples = Example::get();
        return $this->render($this->views . '.edit', compact('record', 'options', 'examples'));
    }

    public function update(CrudRequest $request, Crud $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function show(Crud $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function destroy(Crud $record)
    {
        return $record->handleDestroy();
    }

    public function submit(Crud $record)
    {
        $flowApproval = $record->getFlowApproval($this->module);
        return $this->render($this->views . '.submit', compact('record', 'flowApproval'));
    }

    public function submitSave(Crud $record, Request $request)
    {
        $request->validate(['cc' => 'nullable|array']);
        return $record->handleSubmitSave($request);
    }

    public function approval(Crud $record)
    {
        return $this->render($this->views . '.approval', compact('record'));
    }

    public function reject(Crud $record, Request $request)
    {
        $request->validate(['note' => 'required|string|max:65500']);
        return $record->handleReject($request);
    }

    public function approve(Crud $record, Request $request)
    {
        return $record->handleApprove($request);
    }

    public function history(Crud $record)
    {
        $this->prepare(['title' => 'History Aktivitas']);
        return $this->render('globals.history', compact('record'));
    }

    public function tracking(Crud $record)
    {
        $this->prepare(['title' => 'Tracking Approval']);
        return $this->render('globals.tracking', compact('record'));
    }

    public function print(Crud $record)
    {
        $title = $this->prepared('title') . ' ' . $record->year;
        $module = $this->prepared('module');
        $pdf = \PDF::loadView($this->views . '.print', compact('title', 'module', 'record'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream(date('Y-m-d') . ' ' . $title . '.pdf');
    }
}
