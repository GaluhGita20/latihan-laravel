@extends('layouts.page')

@section('page')
    <div class="row">
        @include($views.'._card-progress')
    </div>
    <div class="row">
        @include($views.'._chart-user')
    </div>
@endsection
