$(document).ready(function () {
	$('#datepicker').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		todayHighlight: true
	});

	$('#date-popup').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		todayHighlight: true,
        use24hours: true,
        format: 'yyyy-mm-dd hh:mm:ss'
	});

	$('#year-view').datepicker({
		startView: 2,
		keyboardNavigation: false,
		forceParse: false,
		format: "mm/dd/yyyy"
	});

	$(".select2").select2();
	$(".select2-placeholer").select2({
		allowClear: true
	});

	//$('.colorpicker').colorpicker();

	// Colorpicker
	if ($.isFunction($.fn.colorpicker))
	{
		$(".colorpicker").each(function (i, el)
		{
			var $this = $(el);
			var  opts = {
						//format: attrDefault($this, 'format', false)
					};
			var $nextEle = $this.next();
			var $prevEle = $this.prev();
			var $colorPreview = $this.siblings('.input-group-addon').find('.icon-color-preview');

			$this.colorpicker(opts);

			if ($nextEle.is('.input-group-addon') && $nextEle.has('span'))
			{
				$nextEle.on('click', function (ev)
				{
					ev.preventDefault();
					$this.colorpicker('show');
				});
			}

			if ($prevEle.is('.input-group-addon') && $prevEle.has('span'))
			{
				$prevEle.on('click', function (ev)
				{
					ev.preventDefault();
					$this.colorpicker('show');
				});
			}

			if ($colorPreview.length)
			{
				$this.on('changeColor', function (ev) {

					$colorPreview.css('background-color', ev.color.toHex());
				});

				if ($this.val())
				{
					$colorPreview.css('background-color', $this.val());
				}
			}
		});
	}
});
