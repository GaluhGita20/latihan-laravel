@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
        <label class="col-md-3 col-form-label">{{ __('Plant') }}</label>
        <div class="col-md-9 parent-group">
            <select name="plant_id" class="form-control base-plugin--select2-ajax tipe_id"
                data-url="{{ route('ajax.selectPlant', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->plant_id))
					<option value="{{ $record->plant_id }}" selected>{{ $record->plant->name }}</option>
				@endif
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{ __('Nama') }}</label>
        <div class="col-sm-9 parent-group">
            <input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{ __('Deskripsi') }}</label>
        <div class="col-sm-9 parent-group">
            <textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
        </div>
    </div>
@endsection
