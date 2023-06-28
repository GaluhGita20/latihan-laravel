@extends('layouts.page', ['container' => 'container'])

@section('content-body')
@method('POST')
<div class="container-fluid">
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">Register</h3>
            <div class="card-toolbar">
                @section('card-toolbar')
                @include('layouts.forms.btnBackTop')
                @show
            </div>
        </div>
        <div class="card-body">
            @include($views.'.includes.header')
        </div>
    </div>
</div>

<div class="container-fluid mt-5">
    @include($views.'.includes.show')
</div>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Flow Approval</h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body text-center">
                    @php
                    $colors = [
                    1 => 'primary',
                    2 => 'info',
                    ];
                    @endphp
                    @if ($menu = \App\Models\Setting\Globals\Menu::where('module',
                    'penetapan-konteks.register')->first())
                    @if ($menu->flows()->get()->groupBy('order')->count() == null)
                    <span class="label label-light-info font-weight-bold label-inline" data-toggle="tooltip">Belum
                        memiliki
                        alur persetujuan</span>
                    @else
                    @foreach ($orders = $menu->flows()->get()->groupBy('order') as $i => $flows)
                    @foreach ($flows as $j => $flow)
                    <span class="label label-light-{{ $colors[$flow->type] }} font-weight-bold label-inline"
                        data-toggle="tooltip" title="{{ $flow->show_type }}">{{ $flow->role->name }}</span>
                    @if (!($i === $orders->keys()->last() && $j === $flows->keys()->last()))
                    <i class="mx-2 fas fa-angle-double-right text-muted"></i>
                    @endif
                    @endforeach
                    @endforeach
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Aksi</h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center">
                        <p class="mb-0">
                            Sebelum submit, pastikan isian data sudah lengkap dan alur
                            persetujuan sudah benar
                        </p>
                        @include('layouts.forms.btnDropdownApproval')
                        @include('layouts.forms.modalReject')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('buttons')
@endsection

@push('scripts')
@endpush
@section('card-footer')
@endsection
@section('page-end')
@if ($record->checkAction('approval', $perms))
<div class="card-footer">
    <div class="d-flex justify-content-between">
        @include('layouts.forms.btnBack')
        @include('layouts.forms.btnDropdownApproval')
    </div>
</div>
@include('layouts.forms.modalReject')
@endif
@endsection