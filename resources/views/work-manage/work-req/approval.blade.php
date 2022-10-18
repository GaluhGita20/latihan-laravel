@extends($views.'.show')

@section('buttons')
	@if ($record->checkAction('approval', $perms))
		<div class="card-footer">
			<div class="d-flex justify-content-between">
				@include('layouts.forms.btnBack')
				@include('layouts.forms.btnDropdownApproval')
				@include('layouts.forms.modalReject')
			</div>
		</div>
	@endif
@endsection