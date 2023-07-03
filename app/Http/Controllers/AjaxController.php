<?php

namespace App\Http\Controllers;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Master\Aset;
use App\Models\Master\Parts;
use App\Models\Master\Plant;
use Illuminate\Http\Request;
use App\Models\Master\Lokasi;
use App\Models\Master\System;
use App\Models\Master\SubUnit;
use App\Models\Master\Geo\City;
use App\Models\Master\Komponen;
use App\Models\Master\BiayaLain;
use App\Models\Master\Equipment;
use App\Models\Master\SubLokasi;
use App\Models\Master\Org\Struct;
use App\Models\Master\VendorAset;
use App\Models\Master\Geo\Province;
use App\Models\Master\Org\Position;
use App\Models\Master\PrioritasAset;
use App\Models\Master\Pegawai\Pegawai;
use App\Models\Master\TipeMaintenance;
use App\Models\Master\ItemPemeliharaan;
use App\Models\Setting\Globals\TempFiles;
use App\Models\Setting\Globals\Notification;

class AjaxController extends Controller
{
    public function AsetOptions(Request $request)
    {
        return Aset::select('id', 'name')
            ->when(
                $sub_lokasi_id = $request->sub_lokasi_id,
                function ($q) use ($sub_lokasi_id) {
                    $q->where('sub_lokasi_id', $sub_lokasi_id);
                }
            )
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function getAsetOptions(Request $request)
    {
        return Aset::when(
                $aset_id = $request->aset_id,
                function ($q) use ($aset_id) {
                    $q->where('id', $aset_id);
                }
            )
            ->orderBy('name', 'ASC')
            ->first();
    }

    public function selectProvince($search, Request $request)
    {
        $items = Province::keywordBy('name')->orderBy('name');
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

    public function cityOptionsRoot(Request $request)
    {
        $items = City::when(
            $province_id = $request->province_id,
            function ($q) use ($province_id) {
                $q->where('province_id', $province_id);
            }
        )
            ->orderBy('name', 'ASC')
            ->get();

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function subLokasiOptions(Request $request)
    {
        return SubLokasi::select('id', 'name')
            ->when(
                $location_id = $request->location_id,
                function ($q) use ($location_id) {
                    $q->where('location_id', $location_id);
                }
            )
            ->when(
                $struct_id = $request->struct_id,
                function ($q) use ($struct_id) {
                    $q->where('struct_id', $struct_id);
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

    public function selectAset($search, Request $request)
    {
        $items = Aset::keywordBy('name')->orderBy('name');
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
            $results[] = ['id' => $item->id, 'text' => $item->name];
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectLocation($search, Request $request)
    {
        $items = Lokasi::keywordBy('name')->orderBy('name');
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
            $results[] = ['id' => $item->id, 'text' => $item->name];
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectSubLocation($search, Request $request)
    {
        $items = SubLokasi::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'by_location':
                $items = $items->where('location_id', $request->location_id);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();

        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = ['id' => $item->id, 'text' => $item->name];
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectMaintenanceType(Request $request, $search = 'all')
    {
        $items = TipeMaintenance::keywordBy('name')->orderBy('name');
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

    public function selectPlant(Request $request, $search = 'all')
    {
        $items = Plant::keywordBy('name')->orderBy('name');
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

    public function selectSystem(Request $request, $search = 'all')
    {
        $items = System::keywordBy('name')->orderBy('name');
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

    public function systemOptions(Request $request)
    {
        $items = System::when(
            $id = $request->id,
            function ($q) use ($id) {
                $q->where('plant_id', $id);
            }
        )
            ->orderBy('name', 'ASC')
            ->get();

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectEquipment(Request $request, $search = 'all')
    {
        $items = Equipment::keywordBy('name')->orderBy('name');
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

    public function equipmentOptions(Request $request)
    {
        $items = Equipment::when(
            $id = $request->id,
            function ($q) use ($id) {
                $q->where('system_id', $id);
            }
        )
            ->orderBy('name', 'ASC')
            ->get();

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectSubUnit(Request $request, $search = 'all')
    {
        $items = SubUnit::keywordBy('name')->orderBy('name');
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

    public function subUnitOptions(Request $request)
    {
        $items = SubUnit::when(
            $id = $request->id,
            function ($q) use ($id) {
                $q->where('equipment_id', $id);
            }
        )
            ->orderBy('name', 'ASC')
            ->get();

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectKomponen(Request $request, $search = 'all')
    {
        $items = Komponen::keywordBy('name')->orderBy('name');
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

    public function komponenOptions(Request $request)
    {
        $items = Komponen::when(
            $id = $request->id,
            function ($q) use ($id) {
                $q->where('sub_unit_id', $id);
            }
        )
            ->orderBy('name', 'ASC')
            ->get();

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function asetStructureOptions(Request $request)
    {
        switch ($request->tipe_aset) {
            case 'plant':
                $items = Plant::orderBy('name', 'ASC')->get();
                break;
            case 'system':
                $items = System::orderBy('name', 'ASC')->get();
                break;
            case 'equipment':
                $items = Equipment::orderBy('name', 'ASC')->get();
                break;
            case 'sub-unit':
                $items = SubUnit::orderBy('name', 'ASC')->get();
                break;
            case 'komponen':
                $items = Komponen::orderBy('name', 'ASC')->get();
                break;
            case 'parts':
                $items = Parts::orderBy('name', 'ASC')->get();
                break;   
        }

        // if($request->tipe_aset == "plant"){
        //     $items = Plant::orderBy('name', 'ASC')->get();
        // }

        // if($request->tipe_aset == "system"){
        //     $items = System::orderBy('name', 'ASC')->get();
        // }

        // if($request->tipe_aset == "equipment"){
        //     $items = Equipment::orderBy('name', 'ASC')->get();
        // }

        // if($request->tipe_aset == "sub-unit"){
        //     $items = SubUnit::orderBy('name', 'ASC')->get();
        // }

        // if($request->tipe_aset == "komponen"){
        //     $items = Komponen::orderBy('name', 'ASC')->get();
        // }

        // if($request->tipe_aset == "parts"){
        //     $items = Parts::orderBy('name', 'ASC')->get();
        // }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectAsetWithPrice(Request $request, $search = 'all')
    {
        $items = Aset::keywordBy('name')->orderBy('name');
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

    public function selectVendor(Request $request, $search = 'all')
    {
        $items = VendorAset::keywordBy('name')->orderBy('name');
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

    public function selectMaintenanceItem(Request $request, $search = 'all')
    {
        $items = ItemPemeliharaan::keywordBy('name')->orderBy('name');
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

    public function selectPriority(Request $request, $search = 'all')
    {
        $items = PrioritasAset::keywordBy('name')->orderBy('name');
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

    public function selectAsset(Request $request, $search = 'all')
    {
        $items = Aset::keywordBy('name')->orderBy('name');
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

    public function selectOthersCost(Request $request, $search = 'all')
    {
        $items = BiayaLain::keywordBy('name')->orderBy('name');
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



}
