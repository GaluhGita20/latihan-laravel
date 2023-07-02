@extends('layouts.modal')

@section('modal-body')
<div class="form-group row">
	<label class="col-md-12 col-form-label">{{ __('Plant') }}</label>
	<div class="col-md-12 parent-group">
		<select disabled name="plant_id" class="form-control base-plugin--select2-ajax plant_id"
			data-url="{{ route('ajax.selectPlant', ['search' => 'all']) }}"
			placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->komponen_id))
				<option value="{{ $record->komponen->subUnit->equipment->system->plant->id }}" selected>{{ $record->komponen->subUnit->equipment->system->plant->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-12 col-form-label">{{ __('System') }}</label>
	<div class="col-md-12 parent-group">
		<input type="hidden" name="system_id" value="{{ $record->komponen->subUnit->equipment->system_id }}">
		<select disabled name="system_id" class="form-control base-plugin--select2-ajax system_id"
			data-url="{{ route('ajax.systemOptions', ['id' => '']) }}"
			data-url-origin="{{ route('ajax.systemOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->komponen_id))
				<option value="{{ $record->komponen->subUnit->equipment->system_id }}" selected>{{ $record->komponen->subUnit->equipment->system->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-12 col-form-label">{{ __('Equipment') }}</label>
	<div class="col-md-12 parent-group">
		<input type="hidden" name="equipment_id" value="{{ $record->komponen->subUnit->equipment_id }}">
		<select disabled name="equipment_id" class="form-control base-plugin--select2-ajax equipment_id"
			data-url="{{ route('ajax.equipmentOptions', ['id' => '']) }}"
			data-url-origin="{{ route('ajax.equipmentOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->komponen_id))
				<option value="{{ $record->komponen->subUnit->equipment_id }}" selected>{{ $record->komponen->subUnit->equipment->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-12 col-form-label">{{ __('Sub Unit') }}</label>
	<div class="col-md-12 parent-group">
		<input type="hidden" name="sub_unit_id" value="{{ $record->komponen->sub_unit_id }}">
		<select disabled name="sub_unit_id" class="form-control base-plugin--select2-ajax sub_unit_id"
			data-url="{{ route('ajax.subUnitOptions', ['id' => '']) }}"
			data-url-origin="{{ route('ajax.subUnitOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->komponen_id))
				<option value="{{ $record->komponen->sub_unit_id }}" selected>{{ $record->komponen->subUnit->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-12 col-form-label">{{ __('Komponen') }}</label>
	<div class="col-md-12 parent-group">
		<select disabled name="komponen_id" class="form-control base-plugin--select2-ajax komponen_id"
			data-url="{{ route('ajax.komponenOptions', ['id' => '']) }}"
			data-url-origin="{{ route('ajax.komponenOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->komponen_id))
				<option value="{{ $record->komponen_id }}" selected>{{ $record->komponen->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
	<div class="col-sm-12 parent-group">
		<input disabled type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-12 col-form-label">{{ __('Deskripsi') }}</label>
	<div class="col-sm-12 parent-group">
		<textarea disabled name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
	</div>
</div>
@endsection

@section('buttons')
@endsection