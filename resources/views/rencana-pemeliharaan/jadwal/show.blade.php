@extends('layouts.page', ['container' => 'container'])

@section('card-body')
	@method('POST')
	@include($views.'.includes.notes')
	<hr>
	@include($views.'.includes.header')
	<hr>
	@include($views.'.includes.show')
@endsection

@section('buttons')
@endsection

@push('scripts')
@endpush