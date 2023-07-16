@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
@method('POST')
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('ID Purchase Order') }}</label>
	<div class="col-sm-8 parent-group ">
		<input type="text" name="id_purchase_order" class="form-control" placeholder="{{ __('ID Purchase Order') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-md-4 col-form-label">{{ __('Tanggal Purchase Order') }}</label>
	<div class="col-md-8 parent-group">
		<input type="text" name="tgl_purchase_order"
		class="form-control base-plugin--datepicker tgl_purchase_order" 
		data-options='@json([
			"startDate" => "",
			"endDate"=> now()->format('d/m/Y')
		])'
		placeholder="{{ __('Tanggal Purchase Order') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-md-4 col-form-label">{{ __('Tanggal Kirim') }}</label>
	<div class="col-md-8 parent-group">
		<input type="text" name="tgl_kirim"
		class="form-control base-plugin--datepicker tgl_kirim" 
		data-options='@json([
			"startDate" => "", 
			"endDate"=> ""
		])'
		disabled
		placeholder="{{ __('Tanggal Kirim') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Vendor') }}</label>
	<div class="col-sm-8 parent-group">
		<select required name="vendor_id" class="form-control base-plugin--select2-ajax"
			data-url="{{ route('ajax.selectVendor', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
		</select>
	</div>
</div>
@endsection

@push('scripts')
<script>
	$(function () {
		initDateStart();
	});
</script>
<script>
	$('.modal-dialog').removeClass('modal-md').addClass('modal-lg');
</script>
<script>
	var initDateStart = function () {
		$('.modal-body').on('changeDate', 'input.tgl_purchase_order', function (value) {
			var me = $(this);
			if (me.val()) {
				var startDate = new Date(value.date.valueOf());
				var tgl_kirim = $('.tgl_kirim');
				tgl_kirim.prop('disabled', false)
						.val(me.val())
						.datepicker('setStartDate', startDate)
						.focus();
			}
		});
	}
</script>
@endpush



