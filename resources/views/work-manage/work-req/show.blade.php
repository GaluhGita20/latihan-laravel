@extends('layouts.page', ['container' => 'container-fluid'])

@section('card-body')
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Id Work Request') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->no_request }}" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Judul') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->title }}" disabled>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
				<div class="col-md-8 parent-group">
					<textarea class="form-control" disabled>{!! $record->description !!}</textarea>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Lampiran') }}</label>
				<div class="col-md-8 parent-group">
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
					@if ($files->count() == 0)
						<div class="col-form-label">File tidak tersedia!</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Aset') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->aset->name ?? '' }}" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Lokasi') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->subLocation->lokasi->name ?? '' }}" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Sub Lokasi') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->subLocation->name ?? '' }}" disabled>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('buttons')
@endsection