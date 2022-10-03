<script>
	$(function () {
		initRangeDate();
		handleCombobox();
		handleTableDetail();
	});
</script>
<script>
	var initRangeDate = function () {
		$('.content-page').on('changeDate', 'input.range_start', function (value) {
			var me = $(this);
			if (me.val()) {
				var startDate = new Date(value.date.valueOf());
				var date_end = me.closest('.input-group').find('input.range_end');
				date_end.prop('disabled', false)
						.val(me.val())
						.datepicker('setStartDate', startDate)
						.focus();
			}
		});
	}

	var handleCombobox = function () {
		$('.content-page').on('change', 'select.position_id', function (e) {
			var me = $(this);
			var container = me.closest('tr');
			if (me.val()) {
				var user = container.find('select.user_id');
				var urlOrigin = user.data('url-origin');
				var urlParam = $.param({position_id: me.val()});
				user.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
				user.val(null).prop('disabled', false);
			}
			BasePlugin.initSelect2();
		});
	}

	var handleTableDetail = function () {
		$('.content-page').on('click', '.table-detail .btn-add', function (e) {
			var me = $(this);
			var tbody = me.closest('table').find('tbody').first();
			var last = tbody.find('tr').last();
			var key = last.length ? parseInt(last.data('key')) + 1 : 1;
			var template = `
				<tr data-key="`+key+`">
					<td class="text-center no">`+key+`</td>
					<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
						{{-- Manual Select2 --}}
						<select name="details[`+key+`][example_id]" 
							class="form-control base-plugin--select2"
							placeholder="{{ __('Pilih Salah Satu') }}">
							<option value="">{{ __('Pilih Salah Satu') }}</option>
							@foreach ($examples as $val)
								<option value="{{ $val->id }}">{{ $val->name }}</option>
							@endforeach
						</select>
					</td>
					<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
						{{-- Ajax Select2 --}}
						<select name="details[`+key+`][position_id]" 
							class="form-control base-plugin--select2-ajax position_id"
							data-url="{{ route('ajax.selectPosition', ['search' => 'all']) }}"
							placeholder="{{ __('Pilih Salah Satu') }}">
							<option value="">{{ __('Pilih Salah Satu') }}</option>
						</select>
					</td>
					<td class="text-left parent-group" style="width: 250px; max-width: 250px;">
						{{-- Ajax Select2 Combobox --}}
						<select name="details[`+key+`][user_id]" 
							class="form-control base-plugin--select2-ajax user_id"
							data-url="{{ route('ajax.selectUser', [
								'search' => 'by_position',
								'position_id' => '',
							]) }}"
							data-url-origin="{{ route('ajax.selectUser', [
								'search' => 'by_position'
							]) }}"
							disabled 
							placeholder="{{ __('Pilih Salah Satu') }}">
							<option value="">{{ __('Pilih Salah Satu') }}</option>
						</select>
					</td>
					<td class="text-left parent-group">
						<textarea name="details[`+key+`][description]"
							class="form-control"
							placeholder="{{ __('Textarea') }}"></textarea>
					</td>
					<td class="text-center valign-middle">
						<button type="button"
							class="btn btn-sm btn-icon btn-circle btn-danger btn-remove">
							<i class="fa fa-trash"></i>
						</button>
					</td>
				</tr>
			`;

			tbody.append(template);
			tbody.find('.no').each(function (i, el) {
				$(el).html((i+1));
			});
			tbody.find('.btn-remove').prop('disabled', false);
			if (tbody.find('.btn-remove').length == 1) {
				tbody.find('.btn-remove').prop('disabled', true);
			}

			BasePlugin.initSelect2();
		});

		$('.content-page').on('click', '.table-detail .btn-remove', function (e) {
			var me = $(this);
			var tbody = me.closest('table').find('tbody').first();

			me.closest('tr').remove();
			tbody.find('.no').each(function (i, el) {
				$(el).html((i+1));
			});
			tbody.find('.btn-remove').prop('disabled', false);
			if (tbody.find('.btn-remove').length == 1) {
				tbody.find('.btn-remove').prop('disabled', true);
			}

			BasePlugin.initSelect2();
		});
	}
</script>