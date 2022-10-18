<script>
	$(function () {
		handleCombobox();
	});
</script>
<script>
	var handleCombobox = function () {
		$('.content-page').on('change', 'select.location_id', function (e) {
			var me = $(this);
			var container = me.closest('form');
			if (me.val()) {
				var user = container.find('select.sub_location_id');
				var urlOrigin = user.data('url-origin');
				var urlParam = $.param({location_id: me.val()});
				user.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
				user.val(null).prop('disabled', false);
			}
			BasePlugin.initSelect2();
		});
	}
</script>