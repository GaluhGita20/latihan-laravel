@extends('layouts.modal')

@section('modal-body')
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
        <div class="col-sm-12 parent-group">
            <input class="form-control" disabled value="{{ $record->aset->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Id Parts') }}</label>
        <div class="col-sm-12 parent-group">
            <input class="form-control" disabled value="{{ $record->part->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Id Assemblies') }}</label>
        <div class="col-sm-12 parent-group">
            <input class="form-control" disabled value="{{ $record->assemblies->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Id Instruksi') }}</label>
        <div class="col-sm-12 parent-group">
            <input class="form-control" disabled value="{{ $record->name }}">
        </div>
    </div>
@endsection

@section('buttons')
@endsection
