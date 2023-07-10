@extends('layouts.lists')

@inject('menu', 'App\Models\Setting\Globals\Menu')

@section('filters')
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-3 pb-2">
		<select class="form-control base-plugin--select2-ajax filter-control" data-post="module_name"
			data-placeholder="{{ __('Modul') }}">
			<option value="" selected>{{ __('Modul') }}</option>
			@foreach ($menu->grid()->get() as $menu)
				@if ($menu->parent_id == NULL)
					<option value="{{ $menu->module }}">{{ $menu->show_module }}</option>
				@endif
			@endforeach
		</select>
	</div>
	</div>
@endsection

@section('buttons')
	@if (auth()->user()->checkPerms($perms.'.create'))
		{{-- @include('layouts.forms.btnAddImport') --}}
	@endif
@endsection
