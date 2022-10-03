@extends('layouts.form', ['container' => 'container-fluid'])

@section('action', route($routes.'.update', $record->id))

@section('card-body')
	@method('PATCH')
	@include($views.'.includes.notes')
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Tahun') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" name="year"
						class="form-control base-plugin--datepicker-3"
						data-options='@json([
							"startDate" => now()->format('Y'),
							"endStart" => ""
						])'
						placeholder="{{ __('Tahun') }}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Tanggal') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" name="date"
						class="form-control base-plugin--datepicker"
						data-options='@json([
							"startDate" => now()->format('d/m/Y'),
							"endStart" => ""
						])'
						placeholder="{{ __('Tanggal') }}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Rentang Tanggal') }}</label>
				<div class="col-md-8 parent-group">
					<div class="input-group">
						<input type="text" name="range_start"
							class="form-control base-plugin--datepicker range_start"
							data-options='@json([
								"orientation" => "bottom",
								"startDate" => now()->format('d/m/Y'),
								"endStart" => ""
							])'
							placeholder="{{ __('Mulai') }}">
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="la la-ellipsis-h"></i>
							</span>
						</div>
						<input type="text" name="range_end"
							class="form-control base-plugin--datepicker range_end"
							data-options='@json([
								"orientation" => "bottom",
								"startDate" => now()->format('d/m/Y'),
								"endStart" => ""
							])'
							disabled
							placeholder="{{ __('Selesai') }}">
					</div>
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
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Input') }}</label>
				<div class="col-md-8 parent-group">
					<input type="text" name="input"
						class="form-control"
						placeholder="{{ __('Input') }}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Option') }}</label>
				<div class="col-md-8 parent-group">
					<select name="option"
						class="form-control base-plugin--select2"
						placeholder="{{ __('Pilih Salah Satu') }}">
						<option value="">{{ __('Pilih Salah Satu') }}</option>
						@foreach ($options as $key => $text)
							<option value="{{ $key }}">{{ $text }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">{{ __('Textarea') }}</label>
				<div class="col-md-8 parent-group">
					<textarea name="textarea"
						class="form-control"
						placeholder="{{ __('Textarea') }}"></textarea>
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
							<th class="text-center width-60px valign-middle">
								<button type="button"
									class="btn btn-sm btn-icon btn-circle btn-primary btn-add">
									<i class="fa fa-plus"></i>
								</button>
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($record->details as $detail)
							<tr data-key="{{ $loop->iteration }}">
								<td class="text-center no">{{ $loop->iteration }}</td>
								<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
									{{-- Manual Select2 --}}
									<select name="details[{{ $loop->iteration }}][example_id]"
										class="form-control base-plugin--select2"
										placeholder="{{ __('Pilih Salah Satu') }}">
										<option value="">{{ __('Pilih Salah Satu') }}</option>
										@foreach ($examples as $val)
											<option value="{{ $val->id }}" @if($val->id == $detail->example_id) selected @endif>{{ $val->name }}</option>
										@endforeach
									</select>
								</td>
								<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
									{{-- Ajax Select2 --}}
									<select name="details[{{ $loop->iteration }}][position_id]"
										class="form-control base-plugin--select2-ajax position_id"
										data-url="{{ route('ajax.selectPosition', ['search' => 'all']) }}"
										placeholder="{{ __('Pilih Salah Satu') }}">
										<option value="">{{ __('Pilih Salah Satu') }}</option>
										@if ($detail->user && ($position = $detail->user->position))
											<option value="{{ $position->id }}" selected>{{ $position->name }}</option>
										@endif
									</select>
								</td>
								<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
									{{-- Ajax Select2 Combobox --}}
									<select name="details[{{ $loop->iteration }}][user_id]"
										class="form-control base-plugin--select2-ajax user_id"
										data-url="{{ route('ajax.selectUser', [
											'search' => 'by_position',
											'position_id' => '',
										]) }}"
										data-url-origin="{{ route('ajax.selectUser', [
											'search' => 'by_position'
										]) }}"
										@if (!$detail->user) disabled  @endif
										placeholder="{{ __('Pilih Salah Satu') }}">
										<option value="">{{ __('Pilih Salah Satu') }}</option>
										@if ($user = $detail->user)
											<option value="{{ $user->id }}" selected>{{ $user->name }} ({{ $user->position->name }})</option>
										@endif
									</select>
								</td>
								<td class="text-left parent-group">
									<textarea name="details[{{ $loop->iteration }}][description]"
										class="form-control"
										placeholder="{{ __('Textarea') }}">{!! $detail->description !!}</textarea>
								</td>
								<td class="text-center valign-middle">
									<button type="button"
										@if($loop->count == 1) disabled @endif
										class="btn btn-sm btn-icon btn-circle btn-danger btn-remove">
										<i class="fa fa-trash"></i>
									</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
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
