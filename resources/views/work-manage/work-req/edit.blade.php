@extends('layouts.form', ['container' => 'container-fluid'])

@section('action', route($routes.'.update', $record->id))

@section('card-body')
	@method('PATCH')
	@include($views.'.includes.notes')
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Id Work Request') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" name="no_request"
						class="form-control"
						value="{{ $record->no_request }}" 
						placeholder="{{ __('Id Work Request') }}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Judul') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" name="title"
						class="form-control"
						value="{{ $record->title }}" 
						placeholder="{{ __('Judul') }}">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
				<div class="col-md-8 parent-group">
					<textarea name="description"
						class="form-control"
						placeholder="{{ __('Deskripsi') }}">{!! $record->description !!}</textarea>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Lampiran') }}</label>
				<div class="col-md-8 parent-group">
					<div class="custom-file">
						<input type="hidden"
					    	name="attachments[uploaded]"
					    	class="uploaded"
					    	value="">
					    <input type="file" multiple
					    	class="custom-file-input base-form--save-temp-files"
					    	data-name="attachments"
					    	data-container="parent-group"
					    	data-max-size="20024"
					    	data-max-file="100"
					    	accept="*">
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
					                <input type="hidden" 
					                	name="attachments[files_ids][]" 
					                	value="{{ $file->id }}">
					                <div>Uploaded File:</div>
					                <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
					                	{{ $file->file_name }}
					                </a>
					            </div>
					            <div class="alert-close">
					                <button type="button" 
					                	class="close base-form--remove-temp-files" 
					                	data-toggle="tooltip" 
					                	data-original-title="Remove">
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
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Aset') }}</label>
				<div class="col-md-8 parent-group">
					<select name="aset_id"
						class="form-control base-plugin--select2-ajax aset_id"
						data-url="{{ route('ajax.selectAset', ['search' => 'all']) }}"
						placeholder="{{ __('Pilih Salah Satu') }}">
						<option value="">{{ __('Pilih Salah Satu') }}</option>
						@if ($aset = $record->aset)
							<option value="{{ $aset->id }}" selected>{{ $aset->name }}</option>
						@endif
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Lokasi') }}</label>
				<div class="col-md-8 parent-group">
					<select name="location_id"
						class="form-control base-plugin--select2-ajax location_id"
						data-url="{{ route('ajax.selectLocation', ['search' => 'all']) }}"
						placeholder="{{ __('Pilih Salah Satu') }}">
						<option value="">{{ __('Pilih Salah Satu') }}</option>
						@if ($subLocation = $record->subLocation)
							@if ($location = $subLocation->lokasi)
								<option value="{{ $location->id }}" selected>{{ $location->name }}</option>
							@endif
						@endif
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Sub Lokasi') }}</label>
				<div class="col-md-8 parent-group">
					<select name="sub_location_id"
						class="form-control base-plugin--select2-ajax sub_location_id"
						data-url="{{ route('ajax.selectSubLocation', [
							'search' => 'by_location',
							'location_id' => '',
						]) }}"
						data-url-origin="{{ route('ajax.selectSubLocation', [
							'search' => 'by_location'
						]) }}"
						placeholder="{{ __('Pilih Salah Satu') }}">
						<option value="">{{ __('Pilih Salah Satu') }}</option>
						@if ($subLocation = $record->subLocation)
							<option value="{{ $subLocation->id }}" selected>{{ $subLocation->name }}</option>
						@endif
					</select>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('card-footer')
	<div class="d-flex justify-content-between">
		@include('layouts.forms.btnBack')
		@include('layouts.forms.btnDropdownSubmit')
	</div>
@endsection

@push('scripts')
	@include($views.'.includes.scripts')
@endpush
