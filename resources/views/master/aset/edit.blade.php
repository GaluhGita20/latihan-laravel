@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="id_aset" value="{{ $record->id_aset }}" class="form-control" placeholder="{{ __('Id Aset') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Nama Aset') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Struktur Aset') }}</label>
		<div class="col-md-9 parent-group">
			<select name="struktur_aset" class="form-control base-plugin--select2-ajax struktur_aset"
				placeholder="{{ __('Pilih Salah Satu') }}"
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				<option @if($record->struktur_aset == "plant") selected @endif value="plant">{{ __('Plant') }}</option>
				<option @if($record->struktur_aset == "system") selected @endif value="system">{{ __('System') }}</option>
				<option @if($record->struktur_aset == "equipment") selected @endif value="equipment">{{ __('Equipment') }}</option>
				<option @if($record->struktur_aset == "sub-unit") selected @endif value="sub-unit">{{ __('Sub Unit') }}</option>
				<option @if($record->struktur_aset == "komponen") selected @endif value="komponen">{{ __('Komponen') }}</option>
				<option @if($record->struktur_aset == "parts") selected @endif value="parts">{{ __('Parts') }}</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Harga Per Unit') }}</label>
		<div class="col-md-9 parent-group">
			<div class="input-group">
				<div class="input-group-prepend"><span
						class="input-group-text font-weight-bolder">Rp.</span></div>
				<input value="{{ $record->harga_per_unit }}" class="form-control base-plugin--inputmask_currency harga" id="harga_per_unit" name="harga_per_unit" inputmode="numeric"
				placeholder="{{ __('Harga Per Unit') }}">
			</div>
		</div>
	</div>
@endsection
