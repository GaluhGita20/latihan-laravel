@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Item Pemeliharaan') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Item Pemeliharaan') }}">
		</div>
		<label class="col-sm-12 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="description" value="{{ $record->description }}" class="form-control" placeholder="{{ __('Deksripsi') }}">
		</div>
	</div>
@endsection
