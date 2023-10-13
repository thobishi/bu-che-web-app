$(function(){
	$("#HeqfQualificationS1TeachoutDate").datepicker({ 
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
	
	/*
		Multi select functionality start
	*/
		
	$("#HeqfQualificationS1LkpHemisQualifierId").select2({
		minimumInputLength: 3
	});
	
	$("#HeqfQualificationLkpCesm1CodeId").select2({
		minimumInputLength: 2
	});

	$("#HeqfQualificationHemisLkpCesm3CodeId").select2({
		minimumInputLength: 3
	});	
	
	/*
		Multi select functionality end
	*/
});