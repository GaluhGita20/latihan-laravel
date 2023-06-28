<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Tahun') }}</label>
            <div class="col-sm-8 parent-group text-right">
                <input disabled type="text" value="{{ $record->year }}" name="year" class="form-control base-plugin--datepicker-3 width-100px ml-auto text-right" placeholder="{{ __('Tahun') }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Unit Kerja') }}</label>
            <div class="col-sm-8 parent-group">
                <select disabled required name="unit_kerja_id" class="form-control base-plugin--select2-ajax"
                    data-url="{{ route('ajax.selectStruct', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
                    <option value="">{{ __('Pilih Salah Satu') }}</option>
                    @if (!empty($record->unitKerja))
                        <option value="{{ $record->unitKerja->id }}" selected>{{ $record->unitKerja->name }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Lokasi') }}</label>
            <div class="col-sm-8 parent-group">
                <select disabled required name="location_id" class="form-control base-plugin--select2-ajax"
                    data-url="{{ route('ajax.selectLocation', 'all') }}" placeholder="{{ __('Pilih Lokasi') }}">
                    <option value="">{{ __('Pilih Salah Satu') }}</option>
                    @if (!empty($record->location))
                        <option value="{{ $record->location->id }}" selected>{{ $record->location->name }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">{{ __('Sub Lokasi') }}</label>
            <div class="col-md-8 parent-group">
                <select disabled name="sub_location_id" class="form-control base-plugin--select2-ajax"
                    data-url="{{ route('ajax.selectSubLocation', 'all') }}" placeholder="{{ __('Pilih Sub Lokasi') }}">
                    <option value="">{{ __('Pilih Salah Satu') }}</option>
                    @if (!empty($record->subLocation))
                        <option value="{{ $record->subLocation->id }}" selected>{{ $record->subLocation->name }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">{{ __('Aset') }}</label>
            <div class="col-sm-8 parent-group">
                <select disabled name="aset_id" class="form-control base-plugin--select2-ajax"
                    data-url="{{ route('ajax.selectAsset', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
                    <option value="">{{ __('Pilih Salah Satu') }}</option>
                    @if (!empty($record->aset))
                        <option value="{{ $record->aset->id }}" selected>{{ $record->aset->name }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label">{{ __('Uraian') }}</label>
            <div class="col-md-8 parent-group">
                <input disabled type="text" name="uraian" class="form-control" placeholder="{{ __('Uraian') }}">
            </div>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-md-4 col-form-label">{{ __('Lampiran') }}</label>
        <div class="col-md-8 parent-group">
            @php
                $files = $record->files($module)->where('flag', 'attachments')->get();
            @endphp
            @foreach ($files as $file)
                <div class="progress-container w-100" data-uid="{{ $file->id }}">
                    <div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded" role="alert">
                        <div class="alert-icon">
                            <i class="{{ $file->file_icon }}"></i>
                        </div>
                        <div class="alert-text text-left">
                            <input type="hidden" 
                                name="attachments[files_ids][]" 
                                value="{{ $file->id }}">
                            <div>Uploaded File:</div>
                            <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                {{ $file->file_name }}
                            </a>
                        </div>
                        <div class="alert-close">
                            <button type="button" 
                                class="close base-form--remove-temp-files" 
                                data-toggle="tooltip" 
                                data-original-title="Remove">
                                <span aria-hidden="true">
                                    <i class="ki ki-close"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($files->count() == 0)
                <div class="col-form-label">File tidak tersedia!</div>
            @endif
        </div>
    </div>
</div>