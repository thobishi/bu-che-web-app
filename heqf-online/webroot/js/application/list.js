function renderList() {
	var $activeCheckboxes = $('#tableBody input:not([disabled=disabled])');

	var $applicationTypes = $('#application-types');
	var $applicationTypeLinks = $applicationTypes.find('a').detach();

	$applicationTypeLinks.each(function() {
		var $link = $(this);
		var $radio = $('<input type="radio" name="filter" />')
			.val($link.attr('href'))
			.attr('id', $link.attr('id'))
			.attr('checked', $link.hasClass('active'));
		var $label = $('<label />')
			.html($link.html())
			.attr('for', $link.attr('id'));

		$applicationTypes
			.append($radio)
			.append($label);
	});

	$applicationTypes
		.find('input')
		.change(function(e) {
			e.preventDefault();

			window.location = $(this).val();
		});

	$("#ProcessSubmitAll").change(function(){
		var $this = $(this);

		$activeCheckboxes
			.attr('checked', $this.attr('checked'));

		if($this.attr('checked')) {
			$activeCheckboxes
				.attr('checked', true)
				.closest('tr').addClass('selectedRow');
		}
		else {
			$activeCheckboxes
				.attr('checked', false)
				.closest('tr').removeClass('selectedRow');
		}
	});

	$('#tableBody tr').click(function() {
		var $checkbox = $(this).find('input:not([disabled=disabled])');

		if($checkbox.length > 0) {
			$checkbox.attr('checked', !$checkbox.attr('checked'));

			if($checkbox.attr('checked')) {
				$(this).addClass('selectedRow');
			}
			else {
				$(this).removeClass('selectedRow');
			}
		}
	});
}