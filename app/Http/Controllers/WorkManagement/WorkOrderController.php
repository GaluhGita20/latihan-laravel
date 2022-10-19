<?php

namespace App\Http\Controllers\WorkManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkManagement\WorkOrderRequest;
use App\Models\Master\Parts;
use App\Models\WorkManagement\WorkOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WorkOrderController extends Controller
{
    protected $module = 'work.work_order';
    protected $routes = 'work.work_order';
    protected $views  = 'work_management.work_order';
    protected $perms = 'work_order';

    public function __construct()
    {
        $this->prepare(
            [
                'module' => $this->module,
                'routes' => $this->routes,
                'views' => $this->views,
                'perms' => $this->perms,
                'permission' => $this->perms . '.view',
                'title' => 'Work Order',
                'breadcrumb' => [
                    'Work Management' => route($this->routes.'.index'),
                    'Work Order' => route($this->routes . '.index'),
                ]
            ]
        );
    }

    public function index()
    {
        Session::forget('work_order_instruction');
        Session::forget('work_order_other_cost');

        $this->prepare(
            [
                'tableStruct' => [
                    'datatable_1' => [
                        $this->makeColumn('name:num'),
                        $this->makeColumn('name:work_order_id|label:ID Work Order|className:text-left'),
                        $this->makeColumn('name:maintenance_type|label:Tipe Maintenance|className:text-left'),
                        $this->makeColumn('name:asset|label:Asset|className:text-left'),
                        $this->makeColumn('name:user|label:Pelaksana|className:text-left'),
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
        $records = WorkOrder::with(['asset', 'maintenance_type'])->grid()->filters()->dtGet();

        return \DataTables::of($records)
            ->addColumn('num', function ($record) {
                return request()->start;
            })
            ->addColumn('work_order_id', function($record) {
                return $record->work_order_id;
            })
            ->addColumn('maintenance_type', function($record) {
                return $record->maintenance_type->name;
            })
            ->addColumn('asset', function($record) {
                return $record->asset->name;
            })
            ->addColumn('user', function($record) {
                return implode(", ", array_column($record->getUser($record->user_id), 'name')) ;
            })
            ->addColumn('status', function($record) {
                return $record->getStatusName();
            })
            ->addColumn('updated_by', function ($record) {
                return $record->createdByRaw();
            })
            ->addColumn('action', function ($record) use ($user) {
                $actions = [
                    'page:base-content--replace|type:show|id:'.$record->id,
                ];

                if(!in_array($record->status, [WorkOrder::COMPLETE])) {
                    $actions[] = [
                        "page" => 'base-content--replace',
                        'type' => 'edit',
                        'id' => $record->id,
                    ];

                    if ($record->canDeleted()) {
                        $actions[] = [
                            'type' => 'delete',
                            'id' => $record->id,
                            'attrs' => 'data-confirm-text="'.__('Hapus').' '.$record->name.'?"',
                            "page" => "",
                        ];
                    }
                } 

                return $this->makeButtonDropdown($actions);
            })  
            ->rawColumns(['action','updated_by', 'status'])
            ->make(true);
    }

    public function create()
    {
        return $this->render($this->views.'.create');
    }

    public function show(WorkOrder $record)
    {
        return $this->render($this->views.'.show', compact('record'));
    }

    public function store(WorkOrderRequest $request)
    {
        $instruction = session('work_order_instruction');
        $other_cost = session('work_order_other_cost');

        $request->request->add(["instruction" => $instruction]);
        $request->request->add(["other_costs" => $other_cost]);

        if ($request->file('attachment') != NULL) {
            $filename =$request->file('attachment')->getClientOriginalName();
            $rename = uniqid() . '_' . $filename;
            $tujuan_upload = 'work_management/work_order';
            $request->file('attachment')->move($tujuan_upload, $rename);

            $file = [
                'original_name' => $filename,
                'path' => $tujuan_upload . '/' . $rename
            ];
                    
            $request->request->add(["attachments" => $file]);
        } else {
            $request->request->add(["attachments" => null]);
        }

        $record = new WorkOrder;
        return $record->handleStoreOrUpdate($request);
    }

    public function edit(WorkOrder $record)
    {
        if(!session()->has('work_order_instruction')){
            session(['work_order_instruction' => json_decode($record->instruction, true)]);
        }

        if(!session()->has('work_order_other_cost')){
            session(['work_order_other_cost' => json_decode($record->other_costs, true)]);
        }
 
        return $this->render($this->views.'.edit', compact('record'));
    }

    public function update(WorkOrderRequest $request, WorkOrder $record)
    {
        $instruction = session('work_order_instruction');
        $other_cost = session('work_order_other_cost');

        $request->request->add(["instruction" => $instruction]);
        $request->request->add(["other_costs" => $other_cost]);

        if ($request->file('attachment') != NULL) {
            $this->handleDestroyFiles([json_decode($record->attachment, true)]);

            $filename =$request->file('attachment')->getClientOriginalName();
            $rename = uniqid() . '_' . $filename;
            $tujuan_upload = 'work_management/work_order';
            $request->file('attachment')->move($tujuan_upload, $rename);

            $file = [
                'original_name' => $filename,
                'path' => $tujuan_upload . '/' . $rename
            ];
                    
            $request->request->add(["attachments" => $file]);
        }

        return $record->handleStoreOrUpdate($request);
    }

    public function destroy(WorkOrder $record)
    {
        return $record->handleDestroy();
    }

    public function getParts(Request $request)
    {
        if($request->ajax()){
            $user = auth()->user();
            $records = Parts::with('statusAset', 'kondisiAset', 'tipeAset', 'lokasi')->grid()->dtGet();

            return \DataTables::of($records)
                ->addIndexColumn()
                ->addColumn('part_code', function($record) {
                    return $record->code;
                })
                ->addColumn('name', function($record) {
                    return $record->name;
                })
                ->addColumn('action', function ($record) use ($user) {
                    $actions = [
                        'type:show|routename:master.parts.show|id:'.$record->id,
                    ];

                    return $this->makeButtonDropdown($actions);
                })  
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function showParts(Parts $record)
    {
        return $this->render('master.parts.show', compact('record'));
    }

    public function storeInstruction(Request $request)
    {
        $attachments = array();

        if ($request->file('attachments_instruction_input') != NULL) {
			try {
                $instruction_attachments = $request->file('attachments_instruction_input');
                foreach ($instruction_attachments as $attachment) {
                    $filename = $attachment->getClientOriginalName();
                    $rename = uniqid() . '_' . $filename;
                    $tujuan_upload = 'work_management/work_order/instruction';
                    $attachment->move($tujuan_upload, $rename);

                    $file = [
                        'original_name' => $filename,
                        'path' => $tujuan_upload.'/'.$rename
                    ];

                    array_push($attachments, $file);
                }
			} catch (Exception $e) {
				$message = "Max Upload Size Limit is Exceeded";
				return response()->json(['message' => $message]);
			}
		}

        $data = [
			'id' => $request->id,
			'name' => $request->instruction_input,
			'attachments' => $attachments
		];

		Session::push('work_order_instruction', $data);

		return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }

    public function updateInstruction(Request $request)
    {
        $attachments = array();

        $id = $request->id;

		$work_instructions = session()->pull('work_order_instruction', []);
		foreach ($work_instructions as $key => $work_instruction) {
			if ($work_instruction['id'] == $id) {
                if($request->hasFile('attachments_instruction_input')){
                    $this->handleDestroyFiles($work_instruction['attachments']);
                } else {
                    $attachments = $work_instruction['attachments'];
                }

				unset($work_instructions[$key]);
			}
		}

		session()->put('work_order_instruction', $work_instructions);

        if ($request->file('attachments_instruction_input') != NULL) {
			try {
                $instruction_attachments = $request->file('attachments_instruction_input');
                foreach ($instruction_attachments as $attachment) {
                    $filename = $attachment->getClientOriginalName();
                    $rename = uniqid() . '_' . $filename;
                    $tujuan_upload = 'work_management/work_order/instruction';
                    $attachment->move($tujuan_upload, $rename);

                    $file = [
                        'original_name' => $filename,
                        'path' => $tujuan_upload.'/'.$rename
                    ];

                    array_push($attachments, $file);
                }
			} catch (Exception $e) {
				$message = "Max Upload Size Limit is Exceeded";
				return response()->json(['message' => $message]);
			}
		}

		Session::push('work_order_instruction', [
			'id' => $request->id,
			'name' => $request->instruction_input,
			'attachments' => $attachments
		]);

        $sortsession = Session::get('work_order_instruction');
        usort($sortsession, function($a, $b){
            return $a['id'] <=> $b['id'];
        });

		session()->put('work_order_instruction', $sortsession);

		return response()->json(['message' => 'success']);
    }

    public function deleteInstruction($id)
    {
        $work_instructions = session()->pull('work_order_instruction', []);
		foreach ($work_instructions as $key => $work_instruction) {
			if ($work_instruction['id'] == $id) {
                $this->handleDestroyFiles($work_instruction['attachments']);

				unset($work_instructions[$key]);
			}
		}

		session()->put('work_order_instruction', $work_instructions);

        return response()->json(['message' => 'success']);
    }

    public function storeOtherCost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'other_cost' => 'required',
            'jumlah' => 'required|regex:/^[0-9\.]+$/',
        ]);
            
        if ($validator->fails()) {
            return response()->json(['message' => 'failed', 'errror' => $validator->errors()]);
        }

		Session::push('work_order_other_cost', [
			'id' => $request->id,
			'other_cost' => json_decode($request->other_cost, true),
			'jumlah' => $request->jumlah
		]);

		return response()->json(['message' => 'success']);
    }

    public function updateOtherCost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'other_cost' => 'required',
            'jumlah' => 'required|regex:/^[0-9\.]+$/',
        ]);
            
        if ($validator->fails()) {
            return response()->json(['message' => 'failed', 'errror' => $validator->errors()]);
        }

        $id = $request->id;

		$other_costs = session()->pull('work_order_other_cost', []);
		foreach ($other_costs as $key => $other_cost) {
			if ($other_cost['id'] == $id) {
				unset($other_costs[$key]);
			}
		}

		session()->put('work_order_other_cost', $other_costs);

		Session::push('work_order_other_cost', [
			'id' => $request->id,
			'other_cost' => json_decode($request->other_cost, true),
			'jumlah' => $request->jumlah
		]);

		return response()->json(['message' => 'success']);
    }

    public function deleteOtherCost($id)
    {
        $other_costs = session()->pull('work_order_other_cost', []);
		foreach ($other_costs as $key => $other_cost) {
			if ($other_cost['id'] == $id) {
				unset($other_costs[$key]);
			}
		}

		session()->put('work_order_other_cost', $other_costs);

        return response()->json(['message' => 'success']);
    }

    public function handleDestroyFiles($files)
    {
        if(count($files) > 0){
            foreach ($files as $file) {
                unlink(public_path() . '/' . $file['path']);
            }
        }
    }

    public function test()
    {
        dd(session('work_order_instruction'));
    }

    private function handleUploadedFiles($request){
        $attachments = array();

        if($request != null){
            $attachment_files = $request;

            foreach ($attachment_files as $attachment) {
                $filename = $attachment->getClientOriginalName();
                $rename = uniqid() . '_' . $filename;
                $tujuan_upload = 'work_management/work_order';
                $attachment->move($tujuan_upload, $rename);

                $file = [
                    'original_name' => $filename,
                    'path' => $tujuan_upload.'/'.$rename
                ];

                array_push($attachments, $file);
            }
        }

        return $attachments;
    }

}
