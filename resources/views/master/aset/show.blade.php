@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->code }}" class="form-control" placeholder="{{ __('Id Aset') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama Aset') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Harga') }}</label>
		<div class="col-md-12 parent-group">
			<div class="input-group">
				<div class="input-group-prepend"><span
						class="input-group-text font-weight-bolder">Rp.</span></div>
				<input disabled value="{{ $record->harga }}" class="form-control base-plugin--inputmask_currency harga" id="harga" name="harga" inputmode="numeric"
				placeholder="{{ __('Harga') }}">
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Status Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->statusAset->name }}" class="form-control" placeholder="{{ __('Status Aset') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kondisi Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->kondisiAset->name }}" class="form-control" placeholder="{{ __('Kondisi Aset') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Tipe Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->tipeAset->name }}" class="form-control" placeholder="{{ __('Tipe Aset') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Lokasi') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->lokasi->name }}" class="form-control" placeholder="{{ __('Lokasi') }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Sub Lokasi') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" value="{{ $record->subLokasi->name }}" class="form-control" placeholder="{{ __('Sub Lokasi') }}" disabled>
		</div>
	</div>

@endsection

@section('buttons')
@endsection
