@extends('layouts.modal')

@section('action', route($routes . '.store'))

@section('modal-body')
    @method('POST')
    <div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Struktur Aset') }}</label>
		<div class="col-md-9 parent-group">
			<select name="tipe_aset" class="form-control base-plugin--select2-ajax tipe_aset"
				placeholder="{{ __('Pilih Salah Satu') }}"
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				<option value="plant">{{ __('Plant') }}</option>
				<option value="system">{{ __('System') }}</option>
				<option value="equipment">{{ __('Equipment') }}</option>
				<option value="sub-unit">{{ __('Sub Unit') }}</option>
				<option value="komponen">{{ __('Komponen') }}</option>
				<option value="parts">{{ __('Parts') }}</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Aset') }}</label>
		<div class="col-md-9 parent-group">
			<select name="aset_id" class="form-control base-plugin--select2-ajax aset_id"
				data-url="{{ route('ajax.asetStructureOptions', ['tipe_aset' => '']) }}"
				data-url-origin="{{ route('ajax.asetStructureOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{ __('Nama') }}</label>
        <div class="col-sm-9 parent-group">
            <input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{ __('Deskripsi') }}</label>
        <div class="col-sm-9 parent-group">
            <textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}"></textarea>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('.content-page').on('change', 'select.tipe_aset', function (e) {
            var me = $(this);
            if (me.val()) {
                var objectId = $('select.aset_id');
                var urlOrigin = objectId.data('url-origin');
                var urlParam = $.param({tipe_aset: me.val()});
                objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
                objectId.val(null).prop('disabled', false);
            }
            BasePlugin.initSelect2();
        });
    });
</script>
@endpush
