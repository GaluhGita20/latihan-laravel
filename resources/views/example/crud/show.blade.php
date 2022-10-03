@extends('layouts.page', ['container' => 'container-fluid'])

@section('card-body')
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Tahun') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->year }}" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Tanggal') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->show_date }}" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Rentang Tanggal') }}</label>
				<div class="col-md-8 parent-group">
					<div class="input-group">
						<input type="text" class="form-control" value="{{ $record->show_range_start }}" disabled>
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="la la-ellipsis-h"></i>
							</span>
						</div>
						<input type="text" class="form-control" value="{{ $record->show_range_end }}" disabled>
					</div>
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
				<label class="col-md-4 col-form-label">{{ __('Input') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->input }}" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Option') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" class="form-control" value="{{ $record->getOption($record->option) }}" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Textarea') }}</label>
				<div class="col-md-8 parent-group">
					<textarea class="form-control" disabled>{!! $record->textarea !!}</textarea>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-bordered table-detail">
					<thead>
						<tr>
							<th class="text-center width-60px">No</th>
							<th class="text-center">Example</th>
							<th class="text-center">Jabatan</th>
							<th class="text-center">User</th>
							<th class="text-center">Deskripsi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($record->details as $detail)
							<tr data-key="{{ $loop->iteration }}">
								<td class="text-center no">{{ $loop->iteration }}</td>
								<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
									{{ $detail->example->name ?? '' }}
								</td>
								<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
									{{ $detail->user->position->name ?? '' }}
								</td>
								<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
									{{ $detail->user->name ?? '' }}
								</td>
								<td class="text-left parent-group">
									<div style="white-space: pre-wrap;">{!! $detail->description !!}</div>
								</td>
							</tr>
						@endforeach
						@if ($record->details->count() == 0)
							<tr>
								<td class="text-center" colspan="5">Data tidak tersedia!</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('buttons')
@endsection