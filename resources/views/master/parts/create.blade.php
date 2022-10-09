@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Parts') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="code" class="form-control" placeholder="{{ __('Id Parts') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama Parts') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama Parts') }}">
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
	{{-- <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id assemblies') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="assemblies_id">
                <option disabled selected value="">Pilih Id assemblies</option>
                @foreach ($ASSEMBLIES as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
		</div>
	</div> --}}
@endsection
