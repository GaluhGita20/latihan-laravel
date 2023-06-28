@extends('layouts.modal')

@section('action', route($routes.'.detailJadwalStore'))

@section('modal-body')
	@method('PATCH')
	<input type="hidden" name="jadwal_id" value="{{ $detail->id }}">

	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Tipe Pemeliharaan') }}</label>
		<div class="col-md-9 parent-group">
            <select name="tipe_pemeliharaan_id" class="form-control base-plugin--select2-ajax tipe_pemeliharaan_id"
                data-url="{{ route('ajax.selectMaintenanceType', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
		<label class="col-md-3 col-form-label">{{ __('Item Pemeliharaan') }}</label>
		<div class="col-md-9 parent-group">
            <select name="item_pemeliharaan_id" class="form-control base-plugin--select2-ajax item_pemeliharaan_id"
                data-url="{{ route('ajax.selectMaintenanceItem', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
		<label class="col-sm-3 col-form-label">{{ __('Bulan') }}</label>
		<div class="col-sm-9 parent-group text-right">
			<input type="text" name="bulan" class="form-control base-plugin--datepicker-3 width-100px ml-auto text-right" 
			placeholder="{{ __('Bulan') }}">
		</div>
	</div>
@endsection

<script>
	$('.modal-dialog').removeClass('modal-md').addClass('modal-lg');
</script>