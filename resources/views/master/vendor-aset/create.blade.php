@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Id Vendor') }}</label>
				<div class="col-sm-9 parent-group">
					<input type="text" name="code" class="form-control" placeholder="{{ __('Id Vendor') }}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Nama Vendor') }}</label>
				<div class="col-sm-9 parent-group">
					<input type="text" name="name" class="form-control" placeholder="{{ __('Nama Vendor') }}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Alamat') }}</label>
				<div class="col-sm-9 parent-group">
					<textarea name="alamat" class="form-control" rows="3" placeholder="{{ __('Alamat') }}"></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Provinsi') }}</label>
				<div class="col-sm-9 parent-group">
					<select class="form-control base-plugin--select2" id="provinceCtrl" name="city_id">
						<option disabled selected value="">Pilih Provinsi</option>
						@foreach ($PROVINCES as $item)
							<option value="{{ $item->id }}">{{ $item->name }}</option>
						@endforeach
					</select> 
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Kota') }}</label>
				<div class="col-sm-9 parent-group">
					<select class="form-control base-plugin--select2" id="cityCtrl" name="city_id">
						<option disabled selected value="">Pilih Kota</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Kode Pos') }}</label>
				<div class="col-sm-9 parent-group">
					<input type="text" name="kodepos" class="form-control" placeholder="{{ __('Kode Pos') }}">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Telepon') }}</label>
				<div class="col-sm-9 parent-group">
					<input type="text" name="telepon" class="form-control" placeholder="{{ __('Telepon') }}">
				</div>
			</div>
		
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
				<div class="col-sm-9 parent-group">
					<input type="text" name="email" class="form-control" placeholder="{{ __('Email') }}">
				</div>
			</div>
		
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('PIC') }}</label>
				<div class="col-sm-9 parent-group">
					<input type="text" name="pic" class="form-control" placeholder="{{ __('PIC') }}">
				</div>
			</div>
		
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">{{ __('Website') }}</label>
				<div class="col-sm-9 parent-group">
					<input type="text" name="website" class="form-control" placeholder="{{ __('Website') }}">
				</div>
			</div>
		</div>
	</div>

	
@endsection

<script>
	$('.modal-dialog').removeClass('modal-md').addClass('modal-lg');
</script>
