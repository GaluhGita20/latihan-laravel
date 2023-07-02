@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
    <div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('id Aset') }}</label>
		<div class="col-sm-9 parent-group">
            <select class="form-control base-plugin--select2" name="aset_id">
                <option disabled selected value="">Pilih Id Aset</option>
                @foreach ($ASET as $item)
                    <option @if($record->aset_id == $item->id) selected @endif
                        value="{{ $item->id }}">
                        {{ $item->code }}
                    </option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label">{{ __('Failur Code') }}</label>
		<div class="col-sm-9 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('name') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Deskripsi') }}</label>
		<div class="col-md-9 parent-group">
			<textarea name="desc" rows="4" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->desc }}</textarea>
		</div>
	</div>
@endsection
