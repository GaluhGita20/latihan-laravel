@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}" disabled>
		</div>
		<label class="col-sm-12 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->description }}" class="form-control" placeholder="{{ __('Deskripsi') }}" disabled>
		</div>
	</div>
@endsection

@section('buttons')
@endsection