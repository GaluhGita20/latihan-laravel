@extends('layouts.lists')

@section('filters')
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-2 pb-2">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Nama & Email') }}">
		</div>
		{{-- <div class="col-12 col-sm-6 col-xl-2 pb-2">
			<input type="text" class="form-control filter-control" data-post="email" placeholder="{{ __('Email') }}">
		</div> --}}
		<div class="col-12 col-sm-6 col-xl-2 pb-2">
			<select class="form-control base-plugin--select2-ajax filter-control" 
				data-post="position_id" 
				data-url="{{ route('ajax.selectPosition', 'all') }}"
				data-placeholder="{{ __('Semua Jabatan') }}">
				<option value="" selected>{{ __('Semua Jabatan') }}</option>
			</select>
		</div>
		<div class="col-12 col-sm-6 col-xl-2 pb-2">
			<select class="form-control base-plugin--select2-ajax filter-control" 
				data-post="role_id" 
				data-url="{{ route('ajax.selectRole', 'all') }}"
				data-placeholder="{{ __('Semua Hak Akses') }}">
				<option value="" selected>{{ __('Semua Hak Akses') }}</option>
			</select>
		</div>
		<div class="col-12 col-sm-6 col-xl-2 pb-2">
			<select class="form-control base-plugin--select2-ajax filter-control" 
				data-post="status" 
				data-placeholder="{{ __('Semua Status') }}">
				<option value="" selected>{{ __('Semua Status') }}</option>
				<option value="active">Active</option>
				<option value="nonactive">Nonactive</option>
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