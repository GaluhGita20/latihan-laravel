@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Id Assamblies') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama Assamblies') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Status Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->statusAset->name }}" class="form-control" placeholder="{{ __('Status Assamblies') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kondisi Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->kondisiAset->name }}" class="form-control" placeholder="{{ __('Kondisi Assamblies') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kondisi Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->kondisiAset->name }}" class="form-control" placeholder="{{ __('Kondisi Assamblies') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Lokasi') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->kondisiAset->name }}" class="form-control" placeholder="{{ __('Lokasi') }}" disabled>
		</div>
	</div>
	
	
@endsection

@section('buttons')
@endsection