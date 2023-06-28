@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Tahun') }}</label>
		<div class="col-sm-9 parent-group text-right">
			<input type="text" name="year" class="form-control base-plugin--datepicker-3 width-100px ml-auto text-right" placeholder="{{ __('Tahun') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Unit Kerja') }}</label>
		<div class="col-sm-9 parent-group">
			<select required name="unit_kerja_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectStruct', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Lokasi') }}</label>
		<div class="col-sm-9 parent-group">
			<select required name="location_id" class="form-control base-plugin--select2-ajax location_id"
				data-url="{{ route('ajax.selectLocation', 'all') }}" data-placeholder="{{ __('Pilih Lokasi') }}">
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Sub Lokasi') }}</label>
		<div class="col-md-9 parent-group">
			<select required name="sub_location_id" class="form-control base-plugin--select2-ajax sub_location_id"
				data-url="{{ route('ajax.selectSubLocation', 'all') }}" data-placeholder="{{ __('Pilih Sub Lokasi') }}">
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Aset') }}</label>
		<div class="col-sm-9 parent-group">
			<select required name="aset_id" class="form-control base-plugin--select2-ajax aset_id"
				data-url="{{ route('ajax.selectAsset', 'all') }}" data-placeholder="{{ __('Pilih Salah Satu') }}">
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Uraian') }}</label>
		<div class="col-md-9 parent-group">
			<input type="text" name="uraian" class="form-control" placeholder="{{ __('Uraian') }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Lampiran') }}</label>
		<div class="col-md-9 parent-group">
			<div class="custom-file">
				<input type="hidden" name="attachments[uploaded]" class="uploaded" value="">
				<input type="file" multiple class="custom-file-input base-form--save-temp-files"
					data-name="attachments" data-container="parent-group" data-max-size="20024" data-max-file="100"
					accept="*">
				<label class="custom-file-label" for="file">Choose File</label>
			</div>
			<div class="form-text text-muted">*Maksimal 20MB</div>
		</div>
	</div>
@endsection