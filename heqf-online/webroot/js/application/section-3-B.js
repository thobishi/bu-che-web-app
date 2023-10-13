$(function() {
	var
		questions = {
			programmeAssessment: {
				template: '<tr>' + $('#programmeAssessmentTemplate').html() + '</tr>',
				tbody: $('#programmeAssessment tbody'),
				rowCount: 0
			}
		};
	
	questions.programmeAssessment.rowCount = questions.programmeAssessment.tbody.find('tr').length;

	setPercentages();
	
	$('body').on("click", ".removeButton", function(e){
		e.preventDefault();
		$(this)
			.closest('tr')
			.fadeOut('fast', function() {$(this).remove();});
	});
	
	$(".addButton").on("click", function(e){
		e.preventDefault();
	
		var question = $(this).attr('data-question');

		$(questions[question].template.replace(/###/g, questions[question].rowCount))
			.hide()
			.find('.removeButton').button().end()
			.appendTo(questions[question].tbody)
			.css({display: 'table-row'})
			.fadeIn('fast');
		questions[question].rowCount++;
	});
	
	function setPercentages(){
		var total = 0,
			hoursInputsTotals = 0;

		$("input.set-hours").each(function(){
			if($(this).val() != 0){
				hoursInputsTotals += parseInt($(this).val());
			}
		});
		
		$("input.set-hours").each(function(){
			var value = parseInt($(this).val());
			var percent = (hoursInputsTotals > 0) ? ((value / hoursInputsTotals) * 100) : 0;
			$(this).closest('tr').find('.percentTotal').text(percent.toFixed(2));
		});
		
		$("#totalHours").html(hoursInputsTotals);

		if($("#HeqfQualificationS3LearningOtherTime").val() == 0){
			$("#HeqfQualificationS3LearningOtherText").closest('tr').hide("slow");
		}
		else{
			$("#HeqfQualificationS3LearningOtherText").closest('tr').show("slow");
		}		
	}
	
	$('form').on('keypress', '.numeric' , function(e){
		var a = [],
			k = e.which;

		for(i = 48; i < 58; i++){
			a.push(i);
		}
		
		// backspace and delete and .
		a.push(0);
		a.push(8);

		if(!($.inArray(k, a) >= 0)){
			e.preventDefault();
		}
	});

	$('form').on('keyup', '.leading-zero' , function(e){
		var $this = $(this);

		$first_digit = $this.val().substring(0,1);
		$second_value = $this.val().substring(1,2);
		
		if($first_digit == 0 && $second_value != '.'){
			$this.val($this.val().replace($first_digit,''));
		}
		
		$value = ($this.val() == '') ? 0 : $this.val();
		$this.val($value);		
	});
	
	$('form').on('keyup', '.set-hours' , function(e){
		setPercentages();
	});
	
	$(".popup").each(function(){
		var
			titleText,
			$this = $(this),
			type = $this.data('type');

		switch(type) {
			case 'wil':
			  titleText = "Work-integrated learning (WIL) is an umbrella term to describe curricular, pedagogic and assessment practices, across a range of academic disciplines that integrate formal learning and workplace concerns. WIL includes, but is not restricted to: Practical experiential learning, simulated learning, laboratory work, practicals and workplace-based learning (CHE Work Integrated Learning: Good Practice Guide, 2011)";
			  break;
			case 'workplace':
			  titleText = "Workplace-based learning takes place when students are placed in work environments for the purpose of learning. Learning in the workplace involves structured activities, frequent monitoring by the institution and a variety of assessment opportunities. (CHE Work Integrated Learning: Good Practice Guide, 2011)";
			  break;
			case 'study':
			  titleText = "Self-study is a form of study where the student is, to a large extent, responsible for their own instruction, without direct supervision or attendance in a class. Self-study may include the use of study guides, books, journal articles, case studies, and multi-media engagement.";
			  break;
			default:
				titleText = "";
		}

		$this.tooltip({
			title: titleText
		});
	});

	if ($('#HeqfQualificationS3HasWil').val() == '0') {
		$('.wil-explain').hide();
	}

	$('#HeqfQualificationS3HasWil').on('change', function() {
		if ($(this).val() == '0') {
			$('.wil-explain').slideUp('fast');
		} else {
			$('.wil-explain').slideDown('fast');
		}
	});
	
	$(".popup").each(function(){
		var
			titleText,
			$this = $(this),
			type = $this.data('type');

		switch(type) {
			case 'wil':
			  titleText = "Work-integrated learning (WIL) is an umbrella term to describe curricular, pedagogic and assessment practices, across a range of academic disciplines that integrate formal learning and workplace concerns. WIL includes, but is not restricted to: Practical experiential learning, simulated learning, laboratory work, practicals and workplace-based learning (CHE Work Integrated Learning: Good Practice Guide, 2011)";
			  break;
			case 'workplace':
			  titleText = "Workplace-based learning takes place when students are placed in work environments for the purpose of learning. Learning in the workplace involves structured activities, frequent monitoring by the institution and a variety of assessment opportunities. (CHE Work Integrated Learning: Good Practice Guide, 2011)";
			  break;
			case 'study':
			  titleText = "Self-study is a form of study where the student is, to a large extent, responsible for their own instruction, without direct supervision or attendance in a class. Self-study may include the use of study guides, books, journal articles, case studies, and multi-media engagement.";
			  break;
			default:
				titleText = "";
		}

		$this.tooltip({
			title: titleText
		});
	});

	if ($('#HeqfQualificationS3HasWil').val() == '0') {
		$('.wil-explain').hide();
	}

	$('#HeqfQualificationS3HasWil').on('change', function() {
		if ($(this).val() == '0') {
			$('.wil-explain').slideUp('fast');
		} else {
			$('.wil-explain').slideDown('fast');
		}
	});

});