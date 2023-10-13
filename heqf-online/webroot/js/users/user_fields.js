$(function() {
	var $instName = $('#UserInstitutionName');
	var $instSelect = $('#UserHeqcInstitutionId');
	var $instNameDiv = $instName.closest('div');
	var $instSelectDiv = $instSelect.closest('div');
	var $instOtherCheck = $('#UserInstitutionOther');
	var instList = [];
	
	$instSelect.find('option').each(function() {
		instList.push({label: $(this).text(), value: $(this).val()});
	});
	
	$instOtherCheck.change(function() {
		if($(this).is(':checked')) {
			$instNameDiv.fadeIn('fast');
			$instSelectDiv.fadeOut('fast');
		}
		else {
			$instNameDiv.fadeOut('fast');
			$instSelectDiv.fadeIn('fast');
		}
	}).change();
	
	$instName.autocomplete({
		source: instList,
		select: function(event, ui) {
			$instSelect.val(ui.item.value);
			$instName.val(ui.item.label);
			
			return false;
		}
	})
	.change(function() {
		$instSelect.val('');
	});
})