@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	{{-- <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Parent') }}</label>
		<div class="col-sm-12 parent-group">
			<select name="parent_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectStruct', 'parent_bod') }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
			</select>
			<div class="form-text text-muted">*Parent berupa Root/Direktur</div>
		</div>
	</div> --}}
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
@endsection
