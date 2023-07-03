@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Tipe Aset') }}</label>
		<div class="col-md-9 parent-group">
			<select name="tipe_aset" class="form-control base-plugin--select2-ajax tipe_aset"
				placeholder="{{ __('Pilih Salah Satu') }}"
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				<option @if($record->tipe_aset == "plant") selected @endif value="plant">{{ __('Plant') }}</option>
				<option @if($record->tipe_aset == "system") selected @endif value="system">{{ __('System') }}</option>
				<option @if($record->tipe_aset == "equipment") selected @endif value="equipment">{{ __('Equipment') }}</option>
				<option @if($record->tipe_aset == "sub-unit") selected @endif value="sub-unit">{{ __('Sub Unit') }}</option>
				<option @if($record->tipe_aset == "komponen") selected @endif value="komponen">{{ __('Komponen') }}</option>
				<option @if($record->tipe_aset == "parts") selected @endif value="parts">{{ __('Parts') }}</option>
			</select>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-md-3 col-form-label">{{ __('Aset') }}</label>
		<div class="col-md-9 parent-group">
			<input type="hidden" name="aset_id" value="{{ $record->aset_id }}">
			<select name="aset_id" class="form-control base-plugin--select2-ajax aset_id"
				data-url="{{ route('ajax.asetStructureOptions', ['tipe_aset' => '']) }}"
				data-url-origin="{{ route('ajax.asetStructureOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
				required>
				<option value="">{{ __('Pilih Salah Satu') }}</option>
                @if (!empty($record->aset_id))
                    <option value="{{ $record->aset_id }}" selected>{{ $record->asetName() }}</option>
                @endif
			</select>
		</div>
	</div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{ __('Nama') }}</label>
        <div class="col-sm-9 parent-group">
            <input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{ __('Deskripsi') }}</label>
        <div class="col-sm-9 parent-group">
            <textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}">{{ $record->description }}</textarea>
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
