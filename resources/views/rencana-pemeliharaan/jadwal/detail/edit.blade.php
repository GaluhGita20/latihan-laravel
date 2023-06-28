@extends('layouts.modal')

@section('action', route($routes.'.detailJadwalUpdate', $detail->jadwal))

@section('modal-body')
	@method('PATCH')
	<input type="hidden" name="jadwal_id" value="{{ $detail->jadwal_id }}">

	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Tipe Pemeliharaan') }}</label>
		<div class="col-md-9 parent-group">
			<select name="tipe_pemeliharaan_id" class="form-control base-plugin--select2-ajax tipe_pemeliharaan_id"
			data-url="{{ route('ajax.selectMaintenanceType', ['search' => 'all']) }}" placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if ($tipePemeliharaan = $record->tipePemeliharaan)
				<option value="{{ $tipePemeliharaan->id }}" selected>{{ $tipePemeliharaan->name }}</option>
			@endif
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Item Pemeliharaan') }}</label>
		<div class="col-md-9 parent-group">
			<select name="item_pemeliharaan_id" class="form-control base-plugin--select2-ajax item_pemeliharaan_id"
			data-url="{{ route('ajax.selectMaintenanceItem', ['search' => 'all']) }}" placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if ($itemPemeliharaan = $record->itemPemeliharaan)
				<option value="{{ $itemPemeliharaan->id }}" selected>{{ $itemPemeliharaan->name }}</option>
			@endif
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Bulan') }}</label>
		<div class="col-md-9 parent-group">
			<div class="input-group">
				<input required type="text" name="bulan"
					class="form-control base-plugin--datepicker" placeholder="{{ __('Bulan') }}" data-orientation="bottom"
					@if(!empty($detail->bulan))
						value="{{ $detail->bulan->format('d/m/Y') }}"
					@endif
					data-options='@json([
							'startDate'=> now()->format('d/m/Y'),
							'endDate' => '',
				])' autocomplete="off">
			</div>
		</div>
	</div>
@endsection
<script>
	$('.modal-dialog').removeClass('modal-md').addClass('modal-lg');
</script>