@extends('layouts.lists')
@section('filters')
	<div class="row">
		<div class="col-12 col-sm-6 col-md-2 pb-2">
		    <input type="text" class="form-control filter-control base-plugin--datepicker-3" 
		        data-post="year" 
		        placeholder="{{ __('Semua Tahun') }}">
		</div>
	</div>
@endsection

@section('buttons')
	@if (auth()->user()->checkPerms($perms.'.create'))
		@include('layouts.forms.btnAdd', ['baseContentReplace' => true])
	@endif
@endsection