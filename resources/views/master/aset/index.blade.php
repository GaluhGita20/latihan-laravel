@extends('layouts.lists')

@section('filters')
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-3 pb-2">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Nama') }}">
		</div>
	</div>
@endsection

@section('buttons')
	@if (auth()->user()->checkPerms($perms.'.create'))
		{{-- @include('layouts.forms.btnAddImport') --}}
		@include('layouts.forms.btnAdd')
	@endif
@endsection

@push('scripts')
    <script>
        $(document)
            .on('change', '#lokasiCtrl', function($e) {
                $.ajax({
                    method: 'GET',
                    url: '{{ url('ajax/sub-lokasi-options') }}',
                    data: {
                        location_id: $(this).val()
                    },
                    success: function(response, state, xhr) {
                        let options = ``;
                        for (let item of response) {
                            options += `<option value='${item.id}'>${item.name}</option>`;
                        }
                        $('#subLokasiCtrl').select2('destroy');
                        $('#subLokasiCtrl').html(options);
                        $('#subLokasiCtrl').select2();
                        console.log(54, response, options);
                    },
                    error: function(a, b, c) {
                        console.log(a, b, c);
                    }
                });
            });
    </script>
@endpush
