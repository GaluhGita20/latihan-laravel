@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
    <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Provinsi') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" id="provinceCtrl" name="city_id">
                <option disabled selected value="">Pilih Provinsi</option>
                @foreach ($PROVINCES as $item)
                    <option @if($record->city->province_id == $item->id) selected @endif
                        value="{{ $item->id }}">
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kota') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" id="cityCtrl" name="city_id">
                <option disabled selected value="">Pilih Kota</option>
                @foreach ($CITIES as $item)
                    <option @if($record->city_id == $item->id) selected @endif
                        value="{{ $item->id }}">
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kode') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="code" value="{{ $record->code }}" class="form-control" placeholder="{{ __('Kode') }}">
		</div>
	</div>

    <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Alamat') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="alamat" value="{{ $record->alamat }}" class="form-control" placeholder="{{ __('Alamat') }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Kode Pos') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="kodepos" value="{{ $record->kodepos }}" class="form-control" placeholder="{{ __('Kode Pos') }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Telepon') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="telepon" value="{{ $record->telepon }}" class="form-control" placeholder="{{ __('Telepon') }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Email') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="email" value="{{ $record->email }}" class="form-control" placeholder="{{ __('Email') }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('PIC') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="pic" value="{{ $record->pic }}" class="form-control" placeholder="{{ __('PIC') }}">
		</div>
	</div>


	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Website') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="website" value="{{ $record->website }}" class="form-control" placeholder="{{ __('Website') }}">
		</div>
	</div>
@endsection
