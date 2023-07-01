@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')

	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Id Aset') }}</label>
		<div class="col-sm-9 parent-group">
            <select class="form-control base-plugin--select2" name="aset_id">
                <option disabled selected value="">Pilih Id Aset</option>
                 @foreach ($ASET as $item) 
                    <option value="{{ $item->id }}">{{ $item->code }}</option>
                @endforeach
            </select>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Failure Code') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Failure Code') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="desc" class="form-control" placeholder="{{ __('Deskripsi') }}">
		</div>
	</div>
@endsection
