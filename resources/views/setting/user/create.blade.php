@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Username') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="username" class="form-control" placeholder="{{ __('Username') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="email" name="email" class="form-control" placeholder="{{ __('Email') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Struktur') }}</label>
		<div class="col-sm-8 parent-group">
			<select id="struktur_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectStruct', ['search'=>'parent_position']) }}"
				data-url-origin="{{ route('ajax.selectStruct', ['search'=>'parent_position']) }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
			</select>
		</div>
	</div>
	<div class="form-group row">
        <label class="col-sm-4 col-form-label">{{ __('Jabatan') }}</label>
        <div class="col-sm-8 parent-group">
            <select class="form-control base-plugin--select2-ajax" 
				data-url="{{ route('ajax.selectPosition', 'parent_position_with_req') }}" id="position_id"
                data-url-origin="{{ route('ajax.selectPosition', 'parent_position_with_req') }}" disabled name="position_id"
                placeholder="{{ __('Pilih Salah Satu') }}">
                <option value="">{{ __('Pilih Salah Satu') }}</option>
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Role') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="roles[]" class="form-control base-plugin--select2-ajax" 
				data-url="{{ route('ajax.selectRole', 'all') }}"
				placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Password') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="password" name="password" class="form-control" placeholder="{{ __('Password') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Konfirmasi Password') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Konfirmasi Password') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="status" class="form-control base-plugin--select2"
				placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="active" selected>Active</option>
				<option value="nonactive">Non Active</option>
			</select>
		</div>
	</div>
@endsection
@push('scripts')
<script>
	$(function () {
		$('.content-page').on('change', '#struktur_id', function (e) {
			var me = $(this);
			if (me.val()) {
				var objectId = $('#position_id');
				var urlOrigin = objectId.data('url-origin');
				var urlParam = $.param({
					parent_id: me.val(),
				});
				objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
				objectId.val(null).prop('disabled', false);
			}
			BasePlugin.initSelect2();
		});
	});
	
</script>
	
@endpush