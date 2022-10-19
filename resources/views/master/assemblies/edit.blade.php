@extends('layouts.modal')

@section('action', route($routes . '.update', $record->id))

@section('modal-body')
    @method('PATCH')
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Id Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <input name="code" class="form-control" placeholder="{{ __('Id Assemblies') }}"
                value="{{ $record->code }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Nama Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <input name="name" class="form-control" placeholder="{{ __(' Nama Assemblies') }}"
                value="{{ $record->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Status Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="status_aset_id">
                <option disabled selected value="">Pilih Status Assemblies</option>
                @foreach ($STATUSASET as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $record->status_aset_id) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Kondisi Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="kondisi_aset_id">
                <option disabled selected value="">Pilih Kondisi Assemblies</option>
                @foreach ($KONDISIASET as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $record->kondisi_aset_id) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Tipe Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="tipe_aset_id">
                <option disabled selected value="">Pilih Tipe Assemblies</option>
                @foreach ($TIPEASET as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $record->tipe_aset_id) selected @endif>
                        {{ $item->name }}</option>
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
                    <option value="{{ $item->id }}" @if ($item->id == $record->location_id) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Sub Lokasi') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" id="subLokasiCtrl" name="sub_lokasi_id">
                <option disabled selected value="">Pilih Sub Lokasi</option>
                @foreach ($SUBLOKASI as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $record->sub_lokasi_id) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
        <div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" id="asetCtrl" name="aset_id">
                <option disabled selected value="">Pilih Id Aset</option>
                @foreach ($ASET as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $record->aset_id) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

@endsection
