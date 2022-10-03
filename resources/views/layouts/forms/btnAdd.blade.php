<a href="{{ $urlAdd ?? (\Route::has($routes.'.create') ? route($routes.'.create') : 'javascript:;') }}" 
	class="btn btn-info  btn-pill {{ empty($baseContentReplace) ? 'base-modal--render' : 'base-content--replace' }}" 
	data-modal-backdrop="false" 
	data-modal-v-middle="false">
	<i class="fa fa-plus"></i> Data
</a>