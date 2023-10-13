$(function() {
	$("#HeqfQualificationS1TeachoutDate").datepicker({ 
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	})
	.closest('.input').removeClass('required');

	$("#HeqfQualificationS1LkpHemisQualifierId").select2({
		minimumInputLength: 3
	});

	$('form').on('submit', function() {
		$("#HeqfQualificationS1LkpHemisQualifierId").removeAttr('disabled');
	});
});

