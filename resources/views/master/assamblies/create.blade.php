@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Id Assamblies') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama Assamblies') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Status Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="status_aset_id">
                <option disabled selected value="">Pilih Status Assamblies</option>
                @foreach ($STATUSASET as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kondisi Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="kondisi_aset_id">
                <option disabled selected value="">Pilih Kondisi Assamblies</option>
                @foreach ($KONDISIASET as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Tipe Assamblies') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="type_asset_id">
                <option disabled selected value="">Pilih Tipe Assamblies</option>
                @foreach ($TIPEASET as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Lokasi') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="location_id">
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
            <select class="form-control base-plugin--select2" name="sub_lokasi_id">
                <option disabled selected value="">Pilih Sub Lokasi</option>
                @foreach ($SUBLOKASI as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div> 
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="aset_id">
                <option disabled selected value="">Pilih Id Aset</option>
                @foreach ($ASET as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div> 
@endsection
