@extends('layouts.modal')

@section('modal-body')
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Tipe Pemeliharaan') }}</label>
		<div class="col-md-9 parent-group">
			<textarea disabled required name="tipe_pemeliharaan_id" class="form-control" placeholder="{{ __('Tipe Pemeliharaan') }}">{{ $detail->tipe_pemeliharaan_id }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Item Pemeliharaan') }}</label>
		<div class="col-md-9 parent-group">
			<textarea disabled required name="item_pemeliharaan_id" class="form-control" placeholder="{{ __('Item Pemeliharaan') }}">{{ $detail->item_pemeliharaan_id }}</textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Bulan') }}</label>
		<div class="col-md-9 parent-group">
			<div class="input-group">
				<input disabled required type="text" name="bulan"
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

@section('buttons')
@endsection
<script>
	$('.modal-dialog').removeClass('modal-md').addClass('modal-lg');
</script>