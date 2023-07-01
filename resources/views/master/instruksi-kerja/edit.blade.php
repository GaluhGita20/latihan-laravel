@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-9 parent-group">
            <select class="form-control base-plugin--select2" name="aset_id">
                <option disabled selected value="">Pilih Id Aset</option>
                @foreach ($ASETS as $item)
                    <option value="{{ $item->id }}" @if($item->id == $record->aset_id) selected @endif>{{ $item->code }}</option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Id Parts') }}</label>
		<div class="col-sm-9 parent-group">
            <select class="form-control base-plugin--select2" name="part_id">
                <option disabled selected value="">Pilih Id Parts</option>
                @foreach ($PARTS as $item)
                    <option value="{{ $item->id }}" @if($item->id == $record->part_id) selected @endif>{{ $item->code }}</option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Id Assemblies') }}</label>
		<div class="col-sm-9 parent-group">
            <select class="form-control base-plugin--select2" name="assemblies_id">
                <option disabled selected value="">Pilih Id Assemblies</option>
                @foreach ($ASSEMBLIES as $item)
                    <option value="{{ $item->id }}" @if($item->id == $record->assemblies_id) selected @endif>{{ $item->code }}</option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Id Instruksi') }}</label>
		<div class="col-sm-9 parent-group">
			<input name="name" class="form-control" placeholder="{{ __('Id Intruksi') }}" value="{{ $record->name }}">
		</div>
	</div>
@endsection
