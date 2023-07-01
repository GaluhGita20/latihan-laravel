@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
        <label class="col-md-12 col-form-label">{{ __('Tipe Pemeliharaan') }}</label>
        <div class="col-md-12 parent-group">
            <select name="tipe_pemeliharaan_id" class="form-control base-plugin--select2-ajax tipe_id"
                data-url="{{ route('ajax.selectMaintenanceType', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->tipe_pemeliharaan_id))
					<option value="{{ $record->tipe_pemeliharaan_id }}" selected>{{ $record->tipePemeliharaan->name }}</option>
				@endif
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}" value="{{ $record->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Deskripsi') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
        </div>
    </div>
@endsection
