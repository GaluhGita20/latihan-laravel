@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Tahun') }}</label>
		<div class="col-sm-8 parent-group text-right">
			<input type="text" value="{{ $record->year }}" name="year" class="form-control base-plugin--datepicker-3 width-100px ml-auto text-right" placeholder="{{ __('Tahun') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Unit Kerja') }}</label>
		<div class="col-sm-8 parent-group">
			<select required name="unit_kerja_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectStruct', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				@if (!empty($record->unitKerja))
					<option value="{{ $record->unitKerja->id }}" selected>{{ $record->unitKerja->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Lokasi') }}</label>
		<div class="col-md-8 parent-group">
			<select name="location_id" class="form-control base-plugin--select2-ajax location_id"
				data-url="{{ route('ajax.selectLocation', ['search' => 'all']) }}" placeholder="{{ __('Pilih Lokasi') }}">
				<option value="">{{ __('Pilih Lokasi') }}</option>
					@if ($location = $record->lokasi)
						<option value="{{ $location->id }}" selected>{{ $location->name }}</option>
					@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Sub Lokasi') }}</label>
		<div class="col-md-8 parent-group">
			<select name="sub_location_id" class="form-control base-plugin--select2-ajax sub_location_id"
				data-url="{{ route('ajax.selectSubLocation', [
					'search' => 'by_location',
					'location_id' => '',
				]) }}"
				data-url-origin="{{ route('ajax.selectSubLocation', [
					'search' => 'by_location'
				]) }}"
				placeholder="{{ __('Pilih Sub Lokasi') }}">
				<option value="">{{ __('Pilih Sub Lokasi') }}</option>
				@if ($subLocation = $record->subLocation)
					<option value="{{ $subLocation->id }}" selected>{{ $subLocation->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Aset') }}</label>
		<div class="col-md-8 parent-group">
			<select name="aset_id" class="form-control base-plugin--select2-ajax aset_id"
				data-url="{{ route('ajax.selectAsset', ['search' => 'all']) }}" placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				@if ($aset = $record->aset)
					<option value="{{ $aset->id }}" selected>{{ $aset->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Uraian') }}</label>
		<div class="col-md-8 parent-group">
			<input type="text" name="uraian" value="{{ $record->uraian }}" class="form-control" placeholder="{{ __('Uraian') }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Lampiran') }}</label>
		<div class="col-md-8 parent-group">
			<div class="custom-file">
				<input type="hidden" name="attachments[uploaded]" class="uploaded" value="">
				<input type="file" multiple 
				class="custom-file-input base-form--save-temp-files" data-name="attachments" data-container="parent-group"
					data-max-size="20024" data-max-file="100" accept="*">
				<label class="custom-file-label" for="file">Choose File</label>
			</div>
			<div class="form-text text-muted">*Maksimal 20MB</div>
			@php
				$files = $record->files($module)->where('flag', 'attachments')->get();
			@endphp
			@foreach ($files as $file)
				<div class="progress-container w-100" data-uid="{{ $file->id }}">
					<div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded" role="alert">
						<div class="alert-icon">
							<i class="{{ $file->file_icon }}"></i>
						</div>
						<div class="alert-text text-left">
							<input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}">
							<div>Uploaded File:</div>
							<a href="{{ $file->file_url }}" target="_blank" class="text-primary">
								{{ $file->file_name }}
							</a>
						</div>
						<div class="alert-close">
							<button type="button" class="close base-form--remove-temp-files" data-toggle="tooltip" data-original-title="Remove">
								<span aria-hidden="true">
									<i class="ki ki-close"></i>
								</span>
							</button>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection