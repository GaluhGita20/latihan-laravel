@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Nama') }}</label>
		<div class="col-md-8 parent-group">
			<input type="text" name="name" value="{{ $record->name }}" class="form-control" placeholder="{{ __('Nama') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="email" name="email" value="{{ $record->email }}" class="form-control" placeholder="{{ __('Email') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Struktur') }}</label>
		<div class="col-sm-8 parent-group">
			<select id="struktur_id" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectStruct', ['search'=>'parent_position']) }}"
				data-url-origin="{{ route('ajax.selectStruct', ['search'=>'parent_position']) }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
				@if ($record->position)
				<option value="{{ $record->position->location->id }}" selected>{{ $record->position->location->name }}</option>
				@endif
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
				@if ($record->position)
				<option value="{{ $record->position->id }}" selected>{{ $record->position->name }}</option>
				@endif
            </select>
        </div>
    </div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Role') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="roles[]" class="form-control base-plugin--select2-ajax" 
				data-url="{{ route('ajax.selectRole', 'all') }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
				<option value="">{{ __('Pilih Salah Satu') }}</option>
				@foreach ($record->roles as $val)
					<option value="{{ $val->id }}" selected>{{ $val->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	@if ($record->id == 1)
		<input type="hidden" name="status" value="active">
	@else
		<div class="form-group row">
			<label class="col-sm-4 col-form-label">{{ __('Status') }}</label>
			<div class="col-sm-8 parent-group">
				<select name="status" class="form-control base-plugin--select2"
					placeholder="{{ __('Pilih Salah Satu') }}">
					<option value="active" {{ $record->status == 'nonactive' ? '' : 'selected' }}>Active</option>
					<option value="nonactive" {{ $record->status == 'nonactive' ? 'selected' : '' }}>Non Active</option>
				</select>
			</div>
		</div>
	@endif
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