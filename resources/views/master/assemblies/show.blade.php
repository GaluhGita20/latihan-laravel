@extends('layouts.modal')

@section('modal-body')
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Id Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" value="{{ $record->code }}" class="form-control" placeholder="{{ __('Id Assemblies') }}"
                disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Nama Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama Assemblies') }}"
                disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Status Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" value="{{ $record->statusAset->name }}" class="form-control"
                placeholder="{{ __('Status Assemblies') }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Kondisi Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" value="{{ $record->kondisiAset->name }}" class="form-control"
                placeholder="{{ __('Kondisi Assemblies') }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Tipe Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" value="{{ $record->tipeAset->name }}" class="form-control"
                placeholder="{{ __('Tipe Assemblies') }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Lokasi') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" value="{{ $record->lokasi->name }}" class="form-control" placeholder="{{ __('Lokasi') }}"
                disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Sub Lokasi') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" value="{{ $record->subLokasi->name }}" class="form-control" placeholder="{{ __('Lokasi') }}"
                disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" value="{{ $record->aset->code }}" class="form-control" placeholder="{{ __('Id Aset') }}"
                disabled>
        </div>
    </div>
@endsection

@section('buttons')
@endsection
