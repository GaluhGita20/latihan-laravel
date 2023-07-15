@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
@method('PATCH')
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('ID Purchase Order') }}</label>
	<div class="col-sm-8 parent-group ">
		<input type="text" name="id_purchase_order" class="form-control" value="{{ $record->id_purchase_order }}" placeholder="{{ __('ID Purchase Order') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-md-4 col-form-label">{{ __('Tanggal Purchase Order') }}</label>
	<div class="col-md-8 parent-group">
		<input type="text" name="tgl_purchase_order"
		class="form-control base-plugin--datepicker" 
		value="{{ $record->tgl_purchase_order->format('d/m/Y') }}"
		data-options='@json([
			"startDate" => now()->format('d/m/Y'),
			"endDate"=> ""
		])'
		placeholder="{{ __('Tanggal Purchase Order') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-md-4 col-form-label">{{ __('Tanggal Kirim') }}</label>
	<div class="col-md-8 parent-group">
		<input type="text" name="tgl_kirim"
		class="form-control base-plugin--datepicker" 
		value="{{ $record->tgl_kirim->format('d/m/Y') }}"
		data-options='@json([
			"startDate" => "", 
			"endDate"=> ""
		])'
		placeholder="{{ __('Tanggal Kirim') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Vendor') }}</label>
	<div class="col-sm-8 parent-group">
		<select required name="vendor_id" class="form-control base-plugin--select2-ajax"
			data-url="{{ route('ajax.selectVendor', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->vendor_id))
				<option value="{{ $record->vendor_id }}" selected>{{ $record->vendor->name }}</option>
			@endif
		</select>
	</div>
</div>
@endsection

<script>
	$('.modal-dialog').removeClass('modal-md').addClass('modal-lg');
</script>
