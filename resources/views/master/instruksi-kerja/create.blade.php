@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="aset_id">
                <option disabled selected value="">Pilih Id Aset</option>
                @foreach ($ASETS as $item)
                    <option value="{{ $item->id }}">{{ $item->code }}</option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Parts') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="part_id">
                <option disabled selected value="">Pilih Id Parts</option>
                @foreach ($PARTS as $item)
                    <option value="{{ $item->id }}">{{ $item->code }}</option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Assemblies') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="assemblies_id">
                <option disabled selected value="">Pilih Id Assemblies</option>
                @foreach ($ASSEMBLIES as $item)
                    <option value="{{ $item->id }}">{{ $item->code }}</option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Id Instruksi') }}</label>
		<div class="col-sm-12 parent-group">
			<input name="name" class="form-control" placeholder="{{ __('Id Intruksi') }}">
		</div>
	</div>
@endsection
