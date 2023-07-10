<?php

namespace App\Http\Controllers\WorkManage\WorkReq;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkManage\WorkReq\WorkReqRequest;
use App\Models\WorkManage\WorkReq\WorkReq;
use App\Models\Master\WorkManage\WorkManage;
use Illuminate\Http\Request;

class WorkReqController extends Controller
{
    protected $module   = 'work-manage.work-req';
    protected $routes   = 'work-manage.work-req';
    protected $views    = 'work-manage.work-req';
    protected $perms    = 'work-manage.work-req';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Work Request',
                'breadcrumb' => [
                    'Work Management'   => route($this->routes . '.index'),
                    'Work Request'        => route($this->routes . '.index'),
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
                        $this->makeColumn('name:no_request|label:Id Work Request|className:text-center'),
                        $this->makeColumn('name:title|label:Judul|className:text-left'),
                        $this->makeColumn('name:description|label:Deskripsi|className:text-left|width:300px'),
                        $this->makeColumn('name:aset|label:Aset|className:text-left'),
                        $this->makeColumn('name:subLocation|label:Lokasi|className:text-left'),
                        $this->makeColumn('name:status'),
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
        $records = WorkReq::grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn('num', function ($record) {
                return request()->start;
            })
            ->addColumn('aset', function ($record) use ($user) {
                return $record->aset->name ?? '';
            })
            ->addColumn('subLocation', function ($record) use ($user) {
                return $record->subLocation->lokasi->name ?? '';
            })
            ->addColumn('status', function ($record) use ($user) {
                return $record->labelStatus($record->status ?? 'new');
            })
            ->addColumn('updated_by', function ($record) {
                return $record->createdByRaw();
            })
            ->addColumn('action', function ($record) use ($user) {
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
            })
            ->rawColumns(['action', 'updated_by', 'status'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views . '.create');
    }

    public function store(WorkReqRequest $request)
    {
        $record = new WorkReq;
        return $record->handleStoreOrUpdate($request);
    }

    public function edit(WorkReq $record)
    {
        return $this->render($this->views . '.edit', compact('record'));
    }

    public function update(WorkReqRequest $request, WorkReq $record)
    {
        return $record->handleStoreOrUpdate($request);
    }

    public function show(WorkReq $record)
    {
        return $this->render($this->views . '.show', compact('record'));
    }

    public function destroy(WorkReq $record)
    {
        return $record->handleDestroy();
    }

    public function submit(WorkReq $record)
    {
        $flowApproval = $record->getFlowApproval($this->module);
        return $this->render($this->views . '.submit', compact('record', 'flowApproval'));
    }

    public function submitSave(WorkReq $record, Request $request)
    {
        $request->validate(['cc' => 'nullable|array']);
        return $record->handleSubmitSave($request);
    }

    public function approval(WorkReq $record)
    {
        return $this->render($this->views . '.approval', compact('record'));
    }

    public function reject(WorkReq $record, Request $request)
    {
        $request->validate(['note' => 'required|string|max:65500']);
        return $record->handleReject($request);
    }

    public function approve(WorkReq $record, Request $request)
    {
        return $record->handleApprove($request);
    }

    public function history(WorkReq $record)
    {
        $this->prepare(['title' => 'History Aktivitas']);
        return $this->render('globals.history', compact('record'));
    }

    public function tracking(WorkReq $record)
    {
        $this->prepare(['title' => 'Tracking Approval']);
        return $this->render('globals.tracking', compact('record'));
    }

    public function print(WorkReq $record)
    {
        $title = $this->prepared('title') . ' ' . $record->year;
        $module = $this->prepared('module');
        $pdf = \PDF::loadView($this->views . '.print', compact('title', 'module', 'record'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream(date('Y-m-d') . ' ' . $title . '.pdf');
    }
}
