@extends('layouts.page_submit_draft')

@section('action', route($routes.'.store'))

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

                    <!-- Left -->
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('ID Work Order') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <input type="text" name="work_order_id" class="form-control" placeholder="{{ __('ID Work Order') }}" disabled value="{{ $record->work_order_id }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Tipe Maintenance') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <select name="maintenance_type_id" class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.selectMaintenanceType', 'all') }}" data-placeholder="{{ __('Pilih Tipe Maintenance') }}" disabled>
                                    @if ($record->maintenance_type)
                                    <option value="{{ $record->maintenance_type->id }}" selected>{{ $record->maintenance_type->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Prioritas') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <select name="priority_id" class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.selectPriority', 'all') }}" data-placeholder="{{ __('Pilih Prioritas') }}" disabled>
                                    @if ($record->priority)
                                    <option value="{{ $record->priority->id }}" selected>{{ $record->priority->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Asset') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <select name="asset_id" class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.selectAsset', 'all') }}" data-placeholder="{{ __('Pilih Asset') }}" disabled>
                                    @if ($record->asset)
                                    <option value="{{ $record->asset->id }}" selected>{{ $record->asset->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('Tgl Target Selesai') }}</label>
                            <div class="col-sm-12 col-md-9 parent-group">
                                <input type="text" name="done_target_date" class="form-control base-plugin--datepicker" data-options='@json([
                                "format" => "d/m/yyyy", ])' data-post="done_target_date" placeholder="{{ __('Tgl Target Selesai') }}" value="{{ WorkOrder::formatDate($record->done_target_date, 'Y-m-d', 'd/m/Y') }}" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- End Of Left -->

                    <!-- Right -->
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Pelaksana') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group">
                                <select name="user_id[]" class="form-control base-plugin--select2-ajax" data-url="{{ route('ajax.selectUser', 'all') }}" data-close-on-select="false" data-allow-clear="true" data-placeholder="{{ __('Pilih Pelaksana') }}" multiple="multiple" disabled>
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
                                <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Deskripsi') }}" disabled>{{ $record->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Perkiraan Biaya') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group">
                                <input type="text" id="estimation_cost" name="estimation_cost" class="form-control" placeholder="{{ __('Perkiraan Biaya') }}" disabled value="{{ $record->currency_estimation_cost }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Diminta Oleh') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group">
                                <input type="text" id="request_by" name="request_by" class="form-control" placeholder="{{ __('Diminta Oleh') }}" disabled value="{{ $record->request_by }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-5 col-form-label">{{ __('Lampiran') }}</label>
                            <div class="col-sm-12 col-md-7 parent-group d-flex align-items-center">
                                @php
                                    $attachment = json_decode($record->attachment);
                                @endphp
                                <a target="_blank" href="{{ asset($attachment->path) }}">{{ $attachment->original_name }}</a>
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
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyTableInstruction">
                                            @if(json_decode($record->instruction, true))
                                            @foreach (json_decode($record->instruction, true) as $key => $instruction)
                                            <tr>
                                                <td class="text-center v-middle">{{ $loop->iteration }}</td>
                                                <td class="text-left v-middle">{{ $instruction["name"] }}</td>
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
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyTableOtherCost">
                                            @if(json_decode($record->other_costs, true))
                                            @foreach (json_decode($record->other_costs, true) as $key => $other_cost)
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
    <div class="col-sm-12">
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

</div>
<!-- end of card bottom -->

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
                </div>
            </form>
        </div>
    </div>
</div>
@show
@push('scripts')
<script src="{{ asset('assets/js/global.js') }}"></script>
<script>
     $(document).ready(() => {
        let url = location.href.replace(/\/$/, "");
        
        if (location.hash) {
            const hash = url.split("#");
            $('#tabWorkOrder a[href="#'+hash[1]+'"]').tab("show");
            
            url = location.href.replace(/\/#/, "#");
            history.replaceState(null, null, url);
            
            setTimeout(() => {
                $(window).scrollTop(0);
            }, 400);
        } 
        
        $('a[data-toggle="tab"]').on("click", function() {
            let newUrl;
            const hash = $(this).attr("href");
            if(hash == "#tab-instruction") {
            newUrl = url.split("#")[0];
            } else {
            newUrl = url.split("#")[0] + hash;
            }

            history.replaceState(null, null, newUrl);
        });

        let table = $('.data-table-parts').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('work.work_order.get.parts') }}",
            sorting: [],
            language: BaseList.lang(),
            lengthChange: false,
		    filter: false,
            columns: [
                {data: 'DT_RowIndex', name: '#', orderable: false, searchable: false },
                {data: 'part_code', name: 'ID Part'},
                {data: 'name', name: 'Name'},
                {data: 'action', name: 'Aksi', orderable: false, searchable: false},
            ]
        });

    });

    function showOtherCost(id, other_cost_name, jumlah) {
        $('#addOtherCostModal').modal('show');

        let result = JSON.parse(other_cost_name);

        $('#editOtherCost').val(true);

        let option = `
            <option value="${result ? result.id : '' }" selected>${result ? result.name : ''}</option>
        `

        $(`#other_cost_id`).append(option)

        $("#addOtherCostModal_data_id").val(id);
        $("input[name=jumlah_other_cost]").val(jumlah);

        $("input[name=jumlah_other_cost]").prop('disabled', true);
        $("#other_cost_id").prop('disabled', true);
    }

    function hideModal(id) {
        if(id == '#addOtherCostModal') {
            $("input[name='jumlah_other_cost']").val('')
            $("#editOtherCost").val('')
            $("#error_jumlah_other_cost").text('')
            $("#error_other_cost_id").text('')
            
            let option = `
                <option value="" selected></option>
            `

            $(`#other_cost_id`).append(option)

            $("input[name=jumlah_other_cost]").prop('disabled', false);
            $("#other_cost_id").prop('disabled', false);
        }

        $(id).modal('hide');
    }
</script>
@endpush
@endsection

