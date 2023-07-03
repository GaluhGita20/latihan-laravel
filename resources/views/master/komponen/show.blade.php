@extends('layouts.modal')

@section('modal-body')
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Plant') }}</label>
	<div class="col-md-9 parent-group">
		<select disabled name="plant_id" class="form-control base-plugin--select2-ajax plant_id"
			data-url="{{ route('ajax.selectPlant', ['search' => 'all']) }}"
			placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->subUnit->equipment_id))
				<option value="{{ $record->subUnit->equipment->system->plant->id }}" selected>{{ $record->subUnit->equipment->system->plant->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('System') }}</label>
	<div class="col-md-9 parent-group">
		<input type="hidden" name="system_id" value="{{ $record->system_id }}">
		<select disabled name="system_id" class="form-control base-plugin--select2-ajax system_id"
			data-url="{{ route('ajax.systemOptions', ['id' => '']) }}"
			data-url-origin="{{ route('ajax.systemOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->subUnit->equipment_id))
				<option value="{{ $record->subUnit->equipment->system_id }}" selected>{{ $record->subUnit->equipment->system->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Equipment') }}</label>
	<div class="col-md-9 parent-group">
		<select disabled name="equipment_id" class="form-control base-plugin--select2-ajax equipment_id"
			data-url="{{ route('ajax.equipmentOptions', ['id' => '']) }}"
			data-url-origin="{{ route('ajax.equipmentOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->subUnit->equipment_id))
				<option value="{{ $record->subUnit->equipment_id }}" selected>{{ $record->subUnit->equipment->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Sub Unit') }}</label>
	<div class="col-md-9 parent-group">
		<input type="hidden" name="sub_unit_id" value="{{ $record->sub_unit_id }}">
		<select disabled name="sub_unit_id" class="form-control base-plugin--select2-ajax sub_unit_id"
			data-url="{{ route('ajax.subUnitOptions', ['id' => '']) }}"
			data-url-origin="{{ route('ajax.subUnitOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->sub_unit_id))
				<option value="{{ $record->sub_unit_id }}" selected>{{ $record->subUnit->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-3 col-form-label">{{ __('Nama') }}</label>
	<div class="col-sm-9 parent-group">
		<input disabled type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-3 col-form-label">{{ __('Deskripsi') }}</label>
	<div class="col-sm-9 parent-group">
		<textarea disabled name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
	</div>
</div>
@endsection

@section('buttons')
@endsection


@push('scripts')
<script>
    $(function () {
            $('.content-page').on('change', 'select.plant_id', function (e) {
                var me = $(this);
                if (me.val()) {
                    var objectId = $('select.system_id');
                    var urlOrigin = objectId.data('url-origin');
                    var urlParam = $.param({id: me.val()});
                    objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
                    objectId.val(null).prop('disabled', false);
                }
                BasePlugin.initSelect2();
            });
        });
</script>
@endpush
