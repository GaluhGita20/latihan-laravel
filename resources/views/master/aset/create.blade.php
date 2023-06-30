@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="code" class="form-control" placeholder="{{ __('Id Aset') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama Aset') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama Aset') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Harga') }}</label>
		<div class="col-md-12 parent-group">
			<div class="input-group">
				<div class="input-group-prepend"><span
						class="input-group-text font-weight-bolder">Rp.</span></div>
				<input class="form-control base-plugin--inputmask_currency harga" id="harga" name="harga" inputmode="numeric"
				placeholder="{{ __('Harga') }}">
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Status Aset') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="status_aset_id">
                <option disabled selected value="">Pilih Status Aset</option>
                @foreach ($STATUSASET as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kondisi Aset') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="kondisi_aset_id">
                <option disabled selected value="">Pilih Kondisi Aset</option>
                @foreach ($KONDISIASET as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Tipe Aset') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="asset_type_id">
                <option disabled selected value="">Pilih Tipe Aset</option>
                @foreach ($TIPEASET as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Lokasi') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" id="lokasiCtrl" name="location_id">
                <option disabled selected value="">Pilih Lokasi</option>
                @foreach ($LOKASI as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Sub Lokasi') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" id="subLokasiCtrl" name="sub_lokasi_id">
                <option disabled selected value="">Pilih Sub Lokasi</option>
            </select>
		</div>
	</div>
@endsection
