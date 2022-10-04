@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="code" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Id Aset') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
@endsection
