@extends('layouts.form', ['container' => 'container-fluid'])

@section('action', route($routes . '.store'))

@section('card-body')
    @method('POST')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-md-4 col-form-label">{{ __('Id Work Request') }}</label>
                <div class="col-md-8 parent-group">
                    <input type="text" name="no_request" class="form-control" placeholder="{{ __('Id Work Request') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label">{{ __('Judul') }}</label>
                <div class="col-md-8 parent-group">
                    <input type="text" name="title" class="form-control" placeholder="{{ __('Judul') }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label">{{ __('Deskripsi') }}</label>
                <div class="col-md-8 parent-group">
                    <textarea name="description" class="form-control" placeholder="{{ __('Deskripsi') }}"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label">{{ __('Lampiran') }}</label>
                <div class="col-md-8 parent-group">
                    <div class="custom-file">
                        <input type="hidden" name="attachments[uploaded]" class="uploaded" value="">
                        <input type="file" multiple class="custom-file-input base-form--save-temp-files"
                            data-name="attachments" data-container="parent-group" data-max-size="20024" data-max-file="100"
                            accept="*">
                        <label class="custom-file-label" for="file">Choose File</label>
                    </div>
                    <div class="form-text text-muted">*Maksimal 20MB</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-md-4 col-form-label">{{ __('Aset') }}</label>
                <div class="col-md-8 parent-group">
                    <select name="aset_id" class="form-control base-plugin--select2-ajax aset_id"
                        data-url="{{ route('ajax.selectAset', ['search' => 'all']) }}"
                        placeholder="{{ __('Pilih Salah Satu') }}">
                        <option value="">{{ __('Pilih Salah Satu') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label">{{ __('Lokasi') }}</label>
                <div class="col-md-8 parent-group">
                    <select name="location_id" class="form-control base-plugin--select2-ajax location_id"
                        data-url="{{ route('ajax.selectLocation', ['search' => 'all']) }}"
                        placeholder="{{ __('Pilih Salah Satu') }}">
                        <option value="">{{ __('Pilih Salah Satu') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label">{{ __('Sub Lokasi') }}</label>
                <div class="col-md-8 parent-group">
                    <select name="sub_location_id" class="form-control base-plugin--select2-ajax sub_location_id"
                        data-url="{{ route('ajax.selectSubLocation', [
                            'search' => 'by_location',
                            'location_id' => '',
                        ]) }}"
                        data-url-origin="{{ route('ajax.selectSubLocation', [
                            'search' => 'by_location',
                        ]) }}"
                        disabled placeholder="{{ __('Pilih Salah Satu') }}">
                        <option value="">{{ __('Pilih Salah Satu') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('card-footer')
    <div class="d-flex justify-content-between">
        @include('layouts.forms.btnBack')
        @include('layouts.forms.btnDropdownSubmit')
    </div>
@endsection

@push('scripts')
    @include($views . '.includes.scripts')
@endpush
