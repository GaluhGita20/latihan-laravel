@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" value="{{ $record->aset->code }}" class="form-control" placeholder="{{ __('Provinsi') }}" disabled>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Failure Code') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-9 parent-group">
			<textarea disabled name="desc" rows="4" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->desc }}</textarea>
		</div>
	</div>
@endsection

@section('buttons')
@endsection
