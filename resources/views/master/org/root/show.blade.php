@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Telepon') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="phone" value="{{ $record->phone }}" class="form-control" placeholder="{{ __('Telepon') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Website') }}</label>
		<div class="col-sm-8 parent-group">
			<input disabled type="text" name="website" value="{{ $record->website }}" class="form-control" placeholder="{{ __('Website') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
		<div class="col-sm-8 parent-group">
			<input disabled type="text" name="email" value="{{ $record->email }}" class="form-control" placeholder="{{ __('Email') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Alamat') }}</label>
		<div class="col-sm-8 parent-group">
			<textarea type="text" name="address" class="form-control" placeholder="{{ __('Address') }}" disabled>{{ $record->address }}</textarea>
		</div>
	</div>
@endsection

@section('buttons')
@endsection
