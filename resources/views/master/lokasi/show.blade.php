@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Struktur') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->struct->name ?? '' }}" class="form-control" placeholder="{{ __('Struktur') }}"  disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Lokasi') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Lokasi') }}" disabled>
		</div>
	</div>
@endsection

@section('buttons')
@endsection