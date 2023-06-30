@extends('layouts.modal')

@section('action', route($routes.'.detailPurchaseStore'))

@section('modal-body')
@method('PATCH')
<input type="hidden" name="purchase_order_id" value="{{ $detail->id }}">
<div class="form-group row">
	<label class="col-sm-3 col-form-label">{{ __('Barang') }}</label>
	<div class="col-sm-9 parent-group">
		<select name="barang_id" class="form-control base-plugin--select2-ajax barang_id" id="asetCtrl"
			data-url="{{ route('ajax.selectAset', ['search' => 'all']) }}"
			placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Jumlah') }}</label>
	<div class="col-md-9 parent-group">
		<div class="input-group">
			<input type="text" id="jumlahCtrl" disabled name="jumlah" class="form-control" placeholder="{{ __('Jumlah') }}">
			<div class="input-group-prepend">
				<span class="input-group-text">Item</span>
			</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Harga Per Unit') }}</label>
	<div class="col-md-9 parent-group">
		<div class="input-group">
			<div class="input-group-prepend"><span
					class="input-group-text font-weight-bolder">Rp.</span></div>
			<input readonly class="form-control base-plugin--inputmask_currency harga_per_unit" id="harga_per_unit" name="harga_per_unit" inputmode="numeric"
			placeholder="{{ __('Harga Per Unit') }}">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Total Harga') }}</label>
	<div class="col-md-9 parent-group">
		<div class="input-group">
			<div class="input-group-prepend"><span
					class="input-group-text font-weight-bolder">Rp.</span></div>
			<input readonly class="form-control base-plugin--inputmask_currency total_harga" id="total_harga" name="total_harga" inputmode="numeric"
			placeholder="{{ __('Total Harga') }}">
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	$(function () {
		$('.content-page')
		.on('change', '#asetCtrl', function(){
			$.ajax({
				method: 'GET',
				url: '{{ url('/ajax/getAsetOptions') }}',
				data: {
					aset_id: $(this).val()
				},
				success: function(response, state, xhr) {
					$('#harga_per_unit').val(response.harga);
					console.log(response.harga);
				},
				error: function(a, b, c) {
					console.log(a, b, c);
				}
			});

			$('#jumlahCtrl').val(null).prop('disabled', false);
			$('#total_harga').val(null);
			$('#harga_per_unit').val(null);
		});
	});

	$(function () {
		$('.content-page')
		.on('keyup', '#jumlahCtrl', function(){

			jumlah = $(this).val();
			console.log(jumlah);
			
			if($('#harga_per_unit').val() != null)
			{
				$('#total_harga').val($('#harga_per_unit').val().split(",").join("") * jumlah);
			}
			
		});
	});
</script>
@endpush