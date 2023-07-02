@extends('layouts.modal')

@section('action', route($routes . '.store'))

@section('modal-body')
    @method('POST')
    <div class="form-group row">
        <label class="col-md-12 col-form-label">{{ __('Plant') }}</label>
        <div class="col-md-12 parent-group">
            <select name="plant_id" class="form-control base-plugin--select2-ajax plant_id"
                data-url="{{ route('ajax.selectPlant', ['search' => 'all']) }}"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('System') }}</label>
		<div class="col-md-12 parent-group">
			<select name="system_id" class="form-control base-plugin--select2-ajax system_id"
				data-url="{{ route('ajax.systemOptions', ['id' => '']) }}"
				data-url-origin="{{ route('ajax.systemOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Equipment') }}</label>
		<div class="col-md-12 parent-group">
			<select name="equipment_id" class="form-control base-plugin--select2-ajax equipment_id"
				data-url="{{ route('ajax.equipmentOptions', ['id' => '']) }}"
				data-url-origin="{{ route('ajax.equipmentOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Sub Unit') }}</label>
		<div class="col-md-12 parent-group">
			<select name="sub_unit_id" class="form-control base-plugin--select2-ajax sub_unit_id"
				data-url="{{ route('ajax.subUnitOptions', ['id' => '']) }}"
				data-url-origin="{{ route('ajax.subUnitOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-md-12 col-form-label">{{ __('Komponen') }}</label>
		<div class="col-md-12 parent-group">
			<select name="komponen_id" class="form-control base-plugin--select2-ajax komponen_id"
				data-url="{{ route('ajax.komponenOptions', ['id' => '']) }}"
				data-url-origin="{{ route('ajax.komponenOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Nama') }}</label>
        <div class="col-sm-12 parent-group">
            <input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-12 col-form-label">{{ __('Deskripsi') }}</label>
        <div class="col-sm-12 parent-group">
            <textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}"></textarea>
        </div>
    </div>
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

        $('.content-page').on('change', 'select.system_id', function (e) {
            var me = $(this);
            if (me.val()) {
                var objectId = $('select.equipment_id');
                var urlOrigin = objectId.data('url-origin');
                var urlParam = $.param({id: me.val()});
                objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
                objectId.val(null).prop('disabled', false);
            }
            BasePlugin.initSelect2();
        });
        
        $('.content-page').on('change', 'select.equipment_id', function (e) {
            var me = $(this);
            if (me.val()) {
                var objectId = $('select.sub_unit_id');
                var urlOrigin = objectId.data('url-origin');
                var urlParam = $.param({id: me.val()});
                objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
                objectId.val(null).prop('disabled', false);
            }
            BasePlugin.initSelect2();
        });

        $('.content-page').on('change', 'select.sub_unit_id', function (e) {
            var me = $(this);
            if (me.val()) {
                var objectId = $('select.komponen_id');
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
