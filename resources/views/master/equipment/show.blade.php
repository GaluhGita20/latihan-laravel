@extends('layouts.modal')

@section('modal-body')
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Plant') }}</label>
	<div class="col-md-9 parent-group">
		<select disabled name="plant_id" class="form-control base-plugin--select2-ajax plant_id"
			data-url="{{ route('ajax.selectPlant', ['search' => 'all']) }}"
			placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->system_id))
				<option value="{{ $record->system->plant->id }}" selected>{{ $record->system->plant->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('System') }}</label>
	<div class="col-md-9 parent-group">
		<input type="hidden" name="system_id" value="{{ $record->system_id }}">
		<select disabled name="system_id" class="form-control base-plugin--select2-ajax system_id"
			data-url="{{ route('ajax.systemOptions', ['id' => '']) }}"
			data-url-origin="{{ route('ajax.systemOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($record->system_id))
				<option value="{{ $record->system_id }}" selected>{{ $record->system->name }}</option>
			@endif
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-3 col-form-label">{{ __('Nama') }}</label>
	<div class="col-sm-9 parent-group">
		<input disabled type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-3 col-form-label">{{ __('Deskripsi') }}</label>
	<div class="col-sm-9 parent-group">
		<textarea disabled name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
	</div>
</div>
@endsection

@section('buttons')
@endsection


@push('scripts')
<script>
    $(function () {
            $('.content-page').on('change', 'select.plant_id', function (e) {
                var me = $(this);
                if (me.val()) {
                    var objectId = $('select.system_id');
                    var urlOrigin = objectId.data('url-origin');
                    var urlParam = $.param({id: me.val()});
                    objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
                    objectId.val(null).prop('disabled', false);
                }
                BasePlugin.initSelect2();
            });
        });
</script>
@endpush
