@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->aset->code }}" class="form-control" placeholder="{{ __('Provinsi') }}" disabled>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Failure Code') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Decs') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->desc }}" class="form-control" placeholder="{{ __('') }}" disabled>
		</div>
	</div>
@endsection

@section('buttons')
@endsection
