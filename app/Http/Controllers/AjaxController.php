<?php

namespace App\Http\Controllers;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Master\Geo\City;
use App\Models\Setting\Globals\Notification;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Setting\Org\Struct;
use App\Models\Setting\Org\Position;
use App\Models\Master\Pegawai\Pegawai;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function cityOptions(Request $request)
    {
        return City::select('id', 'name')
            ->when(
                $province_id = $request->province_id,
                function ($q) use ($province_id) {
                    $q->where('province_id', $province_id);
                }
            )
            ->orderBy('name', 'ASC')
            ->get();
    }
    public function saveTempFiles(Request $request)
    {
        $this->beginTransaction();
        try {
            if ($file = $request->file('file')) {
                $file_path = str_replace('.' . $file->extension(), '', $file->hashName());

                $temp = new TempFiles;
                $temp->file_name = $file->getClientOriginalName();
                $temp->file_path = $file->storeAs('temp-files', $file_path . '/' . $file->getClientOriginalName(), 'public');
                // $temp->file_type = $file->extension();
                $temp->file_size = $file->getSize();
                $temp->flag = $request->flag;
                $temp->save();
                return $this->commit(
                    [
                        'file' => TempFiles::find($temp->id)
                    ]
                );
            }
            return $this->rollback(['message' => 'File not found']);
        } catch (\Exception $e) {
            return $this->rollback(['error' => $e->getMessage()]);
        }
    }

    public function testNotification($emails)
    {
        if ($rkia = Rkia::latest()->first()) {
            request()->merge([
                'module' => 'rkia_operation',
            ]);
            $emails = explode('--', trim($emails));
            $user_ids = User::whereIn('email', $emails)->pluck('id')->toArray();
            $rkia->addNotify([
                'message' => 'Waiting Approval RKIA ' . $rkia->show_category . ' ' . $rkia->year,
                'url' => route('rkia.operation.summary', $rkia->id),
                'user_ids' => $user_ids,
            ]);
            $record = Notification::latest()->first();
            return $this->render('mails.notification', compact('record'));
        }
    }

    public function userNotification()
    {
        $notifications = auth()->user()->notifications()->latest()->simplePaginate(25);
        return $this->render('layouts.base.notification', compact('notifications'));
    }

    public function userNotificationRead(Notification $notification)
    {
        auth()->user()
            ->notifications()
            ->updateExistingPivot($notification, array('readed_at' => now()), false);
        return redirect($notification->full_url);
    }

    public function selectRole($search, Request $request)
    {
        $items = Role::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'approver':
                $perms = str_replace('_', '.', $request->perms) . '.approve';
                $items = $items->whereHas('permissions', function ($q) use ($perms) {
                    $q->where('name', $perms);
                });
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectStruct(Request $request, $search)
    {
        $items = Struct::keywordBy('name')->orderBy('level')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'parent_boc':
                $items = $items->whereIn('level', ['root']);
                break;
            case 'parent_bod':
                $items = $items->whereIn('level', ['root', 'bod']);
                break;
            case 'parent_division':
                $items = $items->whereIn('level', ['bod']);
                break;
            case 'parent_department':
                $items = $items->whereIn('level', ['division']);
                break;
            case 'parent_branch':
                $items = $items->whereIn('level', ['bod']);
                break;
            case 'parent_subbranch':
                $items = $items->whereIn('level', ['branch']);
                break;
            case 'parent_bagian':
                $items = $items->whereIn('level', ['unit']);
                break;
            case 'parent_subbagian':
                $items = $items->whereIn('level', ['bagian']);
                break;
            case 'parent_position':
                $items = $items->whereNotIn('level', ['root', 'group']);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->get();
        $results = [];
        $more = false;

        $levels = [
            'root',
            'unit',
            'boc',
            'bod',
            'division',
            'department',
            'branch',
            'subbranch',
            'bagian',
            'subbagian'
        ];
        $i = 0;
        foreach ($levels as $level) {
            if ($items->where('level', $level)->count()) {
                foreach ($items->where('level', $level) as $item) {
                    $results[$i]['text'] = strtoupper($item->show_level);
                    $results[$i]['children'][] = ['id' => $item->id, 'text' => $item->name];
                }
                $i++;
            }
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectPosition($search, Request $request)
    {
        $items = Position::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectUser($search, Request $request)
    {
        $items = User::keywordBy('name')->has('position')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'auditor':
                $items = $items->whereHas('position', function ($q) {
                    $q->whereHas('location', function ($qq) {
                        $qq->inAudit();
                    });
                });
                break;
            case 'by_position':
                $items = $items->where('position_id', $request->position_id);
                break;
            case 'by_location':
                $items = $items->whereHasLocationId($request->location_id);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();

        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = ['id' => $item->id, 'text' => $item->name . ' (' . $item->position->name . ')'];
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectNip($search, Request $request)
    {
        $items = Pegawai::keywordBy('nip')->orderBy('nip');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();

        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = [
                'id'            => $item->nip,
                'text'          => $item->nip,
                'nama'          => $item->nama,
                'id_jabatan'    => $item->jabatan,
                'nm_jabatan'    => $item->position->name,
                'id_unit'       => $item->unit,
                'nm_unit'       => $item->unit_kerja->name,

            ];
        }
        return response()->json(compact('results', 'more'));
    }

}
