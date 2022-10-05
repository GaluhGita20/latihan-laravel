@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Intstruksi Kerja') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Instruksi Kerja') }}" disabled>
		</div>
	</div>
@endsection

@section('buttons')
@endsection