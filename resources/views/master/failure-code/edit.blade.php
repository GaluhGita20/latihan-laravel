@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
    <div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('id Aset') }}</label>
		<div class="col-sm-12 parent-group">
            <select class="form-control base-plugin--select2" name="province_id">
                <option disabled selected value="">Pilih Id Aset</option>
                @foreach ($PROVINCES as $item)
                    <option @if($record->province_id == $item->id) selected @endif
                        value="{{ $item->id }}">
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Failur Code') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('name') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="desc" value="{{ $record->desc }}" class="form-control" placeholder="{{ __('Deskripsi') }}">
		</div>
	</div>
@endsection
