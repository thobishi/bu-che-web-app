$(function() {
	/*var
		nqfLevelField = $('#HeqfQualificationLkpNqfLevelId'),
		saqaFields = $('#saqaFields'),
		nqfLevels = $.parseJSON($('#nqfLevels').text());

	$('#HeqfQualificationLkpQualificationTypeId').on('change', function() {
		var value = $(this).val();

		if (nqfLevels[value]) {
			nqfLevelField.val(nqfLevels[value]);
		}
	});*/

	/*$("#HeqfQualificationReplaceQual").select2({
		minimumInputLength: 2
	})
	.closest('.input').removeClass('required');	*/
	
	$("#HeqfQualificationLkpCesm1CodeId").select2({
		minimumInputLength: 2
	});

	$("#HeqfQualificationHemisLkpCesm3CodeId").select2({
		minimumInputLength: 3
	});

	/*$('#HeqfQualificationSaqaQualificationId').on('change', function() {
		if (this.value !== '') {
			saqaFields
				.find('.input')
					.removeClass('required')
				.end()
				.find('.error-message').hide();
		} else {
			saqaFields.find('.input').addClass('required').end().find('.error-message').show();
		}
	}).change();*/
	$("#historyBtn").click(function(e){
		e.preventDefault();
		$(".historyDiv").toggle('slow');	
	});	
});