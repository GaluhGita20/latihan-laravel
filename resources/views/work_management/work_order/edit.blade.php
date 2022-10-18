@extends('layouts.page_submit_draft')

@section('action', route($routes.'.update', $record->id))

@section('card-body')
@method('POST')

@section('page-content')

<!-- layouts form -->
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card card-custom">
            @section('card-header')
            <div class="card-header">
                <h3 class="card-title">@yield('card-title', 'Work Order')</h3>
                <div class="card-toolbar">
                    @section('card-toolbar')
                    @include('layouts.forms.btnBackTop')
                    @show
                </div>
            </div>
            @show

            <div class="card-body">
                @csrf
                <div class="row">
                    <input type="hidden" name="created_at" value="{{ $record->created_at }}">
                    <input type="hidden" name="id" value="{{ $record->id }}">

                    <!-- Left -->
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('ID Work Order') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <input type="text" name="work_order_id" class="form-control" placeholder="{{ __('ID Work Order') }}" value="{{ $record->work_order_id }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Tipe Maintenance') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <select name="maintenance_type_id" class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.selectMaintenanceType', 'all') }}" data-placeholder="{{ __('Pilih Tipe Maintenance') }}">
                                @if ($record->maintenance_type_id)
                                    <option value="{{ $record->maintenance_type_id }}" selected>{{ $record->maintenance_type_name }}</option>
                                @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Prioritas') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <select name="priority_id" class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.selectPriority', 'all') }}" data-placeholder="{{ __('Pilih Prioritas') }}">
                                @if ($record->priority_id)
                                    <option value="{{ $record->priority_id }}" selected>{{ $record->priority_name }}</option>
                                @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Asset') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <select name="asset_id" class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.selectAsset', 'all') }}" data-placeholder="{{ __('Pilih Asset') }}">
                                @if ($record->asset_id)
                                    <option value="{{ $record->asset_id }}" selected>{{ $record->asset_name }}</option>
                                @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Tgl Target Selesai') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <input type="text" name="done_target_date" class="form-control base-plugin--datepicker" data-options='@json([
                                "format" => "d/m/yyyy", ])' data-post="done_target_date" placeholder="{{ __('Tgl Target Selesai') }}" value="{{ WorkOrder::formatDate($record->done_target_date, 'Y-m-d', 'd/m/Y') }}">
                            </div>
                        </div>
                    </div>
                    <!-- End Of Left -->

                    <!-- Right -->
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Pelaksana') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group">
                                <select name="user_id[]" class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.selectUser', 'all') }}" data-close-on-select="false" data-allow-clear="true" data-placeholder="{{ __('Pilih Pelaksana') }}" multiple="multiple">
                                @php
                                    $users = WorkOrder::getUser($record->user_id);
                                @endphp
                                @foreach ($users as $key => $user)
                                <option value="{{ $user['id'] }}" selected>{{ $user['alias'] }}</option> 
                                @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Deskripsi') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group">
                                <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Perkiraan Biaya') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group">
                                <input type="text" id="estimation_cost" name="estimation_cost" class="form-control" placeholder="{{ __('Perkiraan Biaya') }}" value="{{ $record->currency_estimation_cost }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Diminta Oleh') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group">
                                <input type="text" id="request_by" name="request_by" class="form-control" placeholder="{{ __('Diminta Oleh') }}" value="{{ $record->request_by }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Lampiran') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group">
                                <input type="file" name="attachment" id="attachment" accept="*" max="20024">
                                {{-- <div class="custom-file">
                                    <input type="hidden" name="attachment[uploaded]" class="uploaded" value="">
                                    <input type="file" multiple class="custom-file-input base-form--save-temp-files" data-name="attachment" data-container="parent-group" data-max-size="20024" data-max-file="100" accept="*">
                                    <label class="custom-file-label" for="file">Choose File</label>
                                </div> --}}
                                <div class="form-text text-muted">*Maksimal 20MB</div>
                                @php
                                    $attachment = json_decode($record->attachment);
                                @endphp
                                <div>File: <a href="{{ asset($attachment->path) }}" _target="blank">{{ $attachment->original_name }}</a></div>
                            </div>
                        </div>
                    </div>
                    <!-- End Of Right -->
                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="mt-2">
                            <ul class="nav nav-tabs" role="tablist" id="tabWorkOrder">
                                <li class="nav-item mx-0">
                                    <a href="#tab-instruction" data-toggle="tab" class="nav-link tab-list nav-link-info active">
                                        <span class="f-w-500">Instruksi Kerja</span>
                                    </a>
                                </li>
                                <li class="nav-item mx-0">
                                    <a href="#tab-other-costs" data-toggle="tab" class="nav-link tab-list nav-link-info">
                                        <span class="f-w-500">Biaya Lain</span>
                                    </a>
                                </li>
                                <li class="nav-item mx-0">
                                    <a href="#tab-parts" data-toggle="tab" class="nav-link tab-list nav-link-info">
                                        <span class="f-w-500">Parts</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <!-- Table Instruksi Kerja -->
                            <div class="tab-pane fade active show" id="tab-instruction">
                                <div class="table-responsive">
                                    <table id="instruction-table" class="table table-bordered table-hover is-datatable" data-tab-list="#tab-instruction" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center v-middle">#</th>
                                                <th class="text-center v-middle">Instruksi Kerja</th>
                                                <th class="text-center width-60px valign-middle">
                                                    <button type="button" data-bs-toggle="modal" data-backdrop="static" data-keyboard="false" data-bs-target="#addInstructionModal" onclick="showModal(this)"
                                                        class="btn btn-sm btn-icon btn-circle btn-primary btn-add">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyTableInstruction">
                                            @if(Session::get('work_order_instruction'))
                                                @php
                                                    $instructions = Session::get('work_order_instruction');
                                                @endphp
                                                @foreach ($instructions as $key => $instruction)
                                                <tr>
                                                    <td class="text-center v-middle">{{ $loop->iteration }}</td>
                                                    <td class="text-left v-middle">{{ $instruction["name"] }}</td>
                                                    <td class="text-left width-60px valign-middle">
                                                        <div class="dropdown dropleft">
                                                            <button type="button" class="btn btn-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ki ki-bold-more-hor"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#addInstructionModal" data-backdrop="static" data-keyboard="false" onclick="updateInstruction('{{ $instruction['id'] }}', '{{ $instruction['name'] }}', {{ json_encode($instruction['attachments']) }} )">
                                                                    <i class="pb-1 mr-3 fa fa-edit text-success"></i>Ubah
                                                                </a>
                                                                <a class="dropdown-item" type="button" onclick="deleteInstruction('{{ $instruction['id'] }}')" data-confirm-text="Hapus Data?">
                                                                    <i class="pb-1 mr-3 fa fa-trash text-danger"></i>Hapus
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End of Table Instruksi Kerja -->

                            <!-- Table Biaya Lain -->
                            <div class="tab-pane fade" id="tab-other-costs">
                                <div class="table-responsive">
                                    <table id="other-cost-table" class="table table-bordered table-hover is-datatable" data-tab-list="#tab-other-costs" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center v-middle">#</th>
                                                <th class="text-center v-middle">Biaya</th>
                                                <th class="text-center v-middle">Jumlah</th>
                                                <th class="text-center v-middle">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addOtherCostModal" onclick="showModal(this)"
                                                        class="btn btn-sm btn-icon btn-circle btn-primary btn-add">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyTableOtherCost">
                                            @if(Session::get('work_order_other_cost'))
                                                @php
                                                    $others_cost = Session::get('work_order_other_cost');
                                                @endphp
                                                @foreach ($others_cost as $key => $other_cost)
                                                <tr>
                                                    <td class="text-center v-middle">{{ $loop->iteration }}</td>
                                                    <td class="text-left v-middle">{{ $other_cost["other_cost"]["name"] }}</td>
                                                    <td class="text-left v-middle">{{ $other_cost["jumlah"] }}</td>
                                                    <td class="text-left width-60px valign-middle">
                                                        <div class="dropdown dropleft">
                                                            <button type="button" class="btn btn-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ki ki-bold-more-hor"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#showOtherCostModal" onclick="showOtherCost('{{ $other_cost['id'] }}', '{{ json_encode($other_cost['other_cost']) }}', '{{ $other_cost['jumlah'] }}')">
                                                                    <i class="pb-1 mr-3 fa fa-eye text-primary"></i>Lihat
                                                                </a>
                                                                <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#addOtherCostModal" onclick="updateOtherCost('{{ $other_cost['id'] }}', '{{ json_encode($other_cost['other_cost']) }}', '{{ $other_cost['jumlah'] }}')">
                                                                    <i class="pb-1 mr-3 fa fa-edit text-success"></i>Ubah
                                                                </a>
                                                                <a class="dropdown-item" type="button" onclick="deleteOtherCost('{{ $other_cost['id'] }}')" data-confirm-text="Hapus Data?">
                                                                    <i class="pb-1 mr-3 fa fa-trash text-danger"></i>Hapus
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End of Table Biaya Lain -->

                            <!-- Table Parts -->
                            <div class="tab-pane fade" id="tab-parts">
                                <div class="table-responsive">
                                    <table class="table table-bordered data-table-parts">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID Part</th>
                                                <th>Name</th>
                                                <th width="100px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End of Table Parts -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of layouts form -->

<!-- Card Bottom -->
<div class="row">
    <!-- bottom -->
    <div class="col-sm-12 col-md-6">
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">@yield('card-title', 'Flow Approval')</h3>
                <div class="card-toolbar">
                    @section('card-toolbar')
                    @include('layouts.forms.btnBackTop')
                    @show
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
    <!-- end of bottom -->

    <!-- right -->
    <div class="col-sm-12 col-md-6">
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">@yield('card-title', 'Aksi')</h3>
                <div class="card-toolbar">
                    @section('card-toolbar')
                    @include('layouts.forms.btnBackTop')
                    @show
                </div>
            </div>
            <div class="card-body">
                @section('buttons')
                <div class="d-flex justify-content-between">
                    @include('layouts.forms.btnBack')
                    @include('layouts.forms.btnDropdownSubmit')
                </div>
                @show
            </div>
        </div>
    </div>
    <!-- end of right -->
</div>
<!-- end of card bottom -->

<!-- Modal Add Instruksi Kerja -->
<div class="modal fade" id="addInstructionModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addInstructionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInstructionModalLabel">Add Instruction</h5>
            </div>
            <form method="POST" id="formInstruction" enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <input type="hidden" name="idInstruction" id="addInstructionModal_data_id" class="form-control">
                    <input type="hidden" name="editInstruction" id="editInstruction" class="form-control">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Instruksi Kerja') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <input type="text" name="instruction_input" class="form-control" placeholder="{{ __('Instruksi Kerja') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Lampiran') }}</label>
                            <div class="col-md-9 parent-group file_instruction">
                                <div class="custom-file">
                                    <input type="hidden" name="attachments_instruction_input[uploaded]" class="uploaded" value="">
                                    <input type="file" id="attachment_instruction_input" multiple class="custom-file-input base-form--save-temp-files" data-name="attachments_instruction_input" data-container="parent-group" data-max-size="20024" data-max-file="100" accept="*">
                                    <label class="custom-file-label" for="file">Choose File</label>
                                </div>
                                <div class="form-text text-muted">*Maksimal 20MB</div>
                                <div class="form-text" id="files_instruction"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hideModal('#addInstructionModal')">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitInstruction()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add Other Cost -->
<div class="modal fade" id="addOtherCostModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addOtherCostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOtherCostModalLabel">Add Other Cost</h5>
            </div>
            <form method="POST" id="formOtherCost" enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <input type="hidden" name="idOtherCost" id="addOtherCostModal_data_id" class="form-control">
                    <input type="hidden" name="editOtherCost" id="editOtherCost" class="form-control">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Biaya Lain') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <select name="other_cost_id" id="other_cost_id" class="form-control base-plugin--select2-ajax"
										data-url="{{ route('ajax.selectOthersCost', 'all') }}"
										data-placeholder="{{ __('Pilih Biaya Lain') }}" required>
								</select>
                                <div class="text-danger" id="error_other_cost_id"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Jumlah') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <input type="text" name="jumlah_other_cost" class="form-control" placeholder="{{ __('Jumlah') }}" required>
                                <div class="text-danger" id="error_jumlah_other_cost"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hideModal('#addOtherCostModal')">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-other-cost" onclick="submitOtherCost()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@show

@endsection
@include('work_management.work_order.script')

