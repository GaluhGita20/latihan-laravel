@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Telepon') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="phone" value="{{ $record->phone }}" class="form-control" placeholder="{{ __('Telepon') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Website') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="website" value="{{ $record->website }}" class="form-control" placeholder="{{ __('Website') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="email" value="{{ $record->email }}" class="form-control" placeholder="{{ __('Email') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Alamat') }}</label>
		<div class="col-sm-8 parent-group">
			<textarea type="text" name="address" class="form-control" placeholder="{{ __('Address') }}">{{ $record->address }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Provinsi') }}</label>
		<div class="col-sm-8 parent-group">
		  <select name="province" class="form-control">
			<option value="">-- Pilih Provinsi --</option>
			<option value="province1">Provinsi 1</option>
			<option value="province2">Provinsi 2</option>
			<option value="province3">Provinsi 3</option>
		  </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Kota/Kabupaten') }}</label>
		<div class="col-sm-8 parent-group">
		  <select name="city" class="form-control">
			<option value="">-- Pilih Kota--</option>
			<option value="city1">Kota 1</option>
			<option value="city2">Kabupaten 2</option>
			<option value="city3">Kota 3</option>
		  </select>
		</div>
	</div>
@endsection
