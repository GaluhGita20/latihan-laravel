@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Prioritas Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Prioritas Aset') }}">
		</div>
		<label class="col-sm-12 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-sm-12 parent-group">
			<textarea name="name" class="form-control" placeholder="{{ __('Deskripsi') }}"></textarea>
		</div>
	</div>
@endsection
