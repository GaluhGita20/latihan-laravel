@extends('layouts.lists')

@section('filters')
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-3 pb-2">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Nama') }}">
		</div>
		<div class="col-12 col-sm-6 col-xl-3 pb-2">
			<select class="form-control filter-control base-plugin--select2-ajax"
				data-post="tipe_aset">
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
@endsection

@section('buttons-right')
	@if (auth()->user()->checkPerms($perms.'.create'))
		{{-- @include('layouts.forms.btnAddImport') --}}
		@include('layouts.forms.btnAdd')
	@endif
@endsection