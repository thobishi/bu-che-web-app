<div id="advanced_search">
	<fieldset><legend>Filter report</legend>
	<?php
		echo $this->Form->create($model, array('url' => $url, 'class' => 'search', 'id' => 'search'));
		echo $this->Form->input('s1_qualification_reference_no', array('label' => 'Qualification reference no', 'type' => 'text' , 'class' => 'searchInput'));
		echo $this->Form->input('s1_lkp_heqf_align_id', array('label' => 'Institution alignment category', 'empty' => 'Select', 'type' => 'select', 'options' => $AppHeqfAlign));
		echo $this->Form->input('lkp_heqf_align_id', array('label' => 'CHE alignment category', 'empty' => 'Select', 'type' => 'select', 'options' => $AppHeqfAlign));
		echo $this->Form->input('s1_qualification_title', array('label' => 'Qualification title (Section 1)', 'type' => 'text'));
		echo $this->Form->input('qualification_title', array('label' => 'Qualification title (Section 2)', 'type' => 'text'));
		echo $this->Form->input('institution_id', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'options' => $Institution));
		echo $this->Form->input('lkp_qualification_type_id', array('label' => 'Section 2 Qualification type', 'empty' => 'Select', 'type' => 'select', 'options' => $QualificationType));
		echo $this->Form->input('heqc_meeting_id', array('label' => 'Application HEQC meeting date', 'empty' => 'Select', 'type' => 'select', 'options' => $HeqcMeeting));
		echo $this->Form->input('proceeding_meeting_date', array('label' => 'Proceeding HEQC meeting date', 'empty' => 'Select', 'type' => 'select', 'options' => $HeqcMeeting));
		
		echo $this->Form->input('status', array('label' => 'Application status', 'empty' => 'Select', 'type' => 'select', 'options' => $Status));

		echo $this->Form->input('lkp_proceeding_type_id', array('label' => 'Proceeding type', 'empty' => 'Select', 'type' => 'select', 'options' => $ProceedingType));

		echo $this->Form->input('lkp_outcome_id', array('label' => 'Outcome', 'empty' => 'Select', 'type' => 'select', 'options' => $ReviewOutcome));
		
		echo $this->Form->input('lkp_cesm1_code_id', array('label' => 'CESM', 'empty' => 'Select', 'type' => 'select', 'options' => $Cesm1Code));
		echo $this->Form->input('lkp_delivery_mode_id', array('label' => 'Mode of delivery', 'empty' => 'Select', 'type' => 'select', 'options' => $DeliveryMode));
		
		echo $this->Form->input('keyword', array('label' => 'Keyword search'));
		/*echo $this->Form->input('archived', array('label' => 'Archived Qualification', 'empty' => 'Select', 'type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes')));*/
		echo $this->Form->input('submission_from_date', array('label' => 'Submission from date', 'type' => 'text', 'class' => 'searchInput'));
		echo $this->Form->input('submission_to_date', array('label' => 'Submission to date', 'type' => 'text', 'class' => 'searchInput', 'after' => '<span class="errorMessage"><br /> The "to" date cannot be smaller than the "from" date.</span>'));
		echo $this->Form->input('review_user_id', array('label' => 'Reviewer', 'empty' => 'Select', 'type' => 'select', 'options' => $ReviewUser));			
		echo $this->Form->submit('Filter', array('id' => 'searchButton', 'value' => 'advancedSearch', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear filter</a>'));
		
		echo $this->Form->end();
	?>
	</fieldset>
</div>
<div style="float:right">
<?php echo '<a id="searchLink" href="#">Report filter</a>';
?>
</div>
<br />
<br />
<script>
$(function() {
	var $advanced_search = $("#advanced_search"),
		$searchLink = $("#searchLink"),
		$clearSearchLink = $("#clearSearchLink"),
		$toDate = $("#ApplicationSubmissionToDate"),
		$fromDate = $("#ApplicationSubmissionFromDate");
		
	$advanced_search.hide();
	$searchLink.click(function(e){
		e.preventDefault();
		$advanced_search.toggle("Fast");
		if($searchLink.html() == 'Report filter'){
			$searchLink.html("Hide report filter");
		}
		else{
			$searchLink.html("Report filter");
		}
	});
	
	$fromDate.datepicker({ 
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
	
	$toDate.datepicker({ 
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
	
	$clearSearchLink.click(function(e){
		e.preventDefault();
		$("#ApplicationLkpDeliveryModeId").val("");
		$("#ApplicationS1QualificationReferenceNo").val("");
		$("#ApplicationLkpHeqfAlignId").val("");
		$("#ApplicationS1LkpHeqfAlignId").val("");
		$("#ApplicationInstitutionId").val("");
		$("#ApplicationLkpQualificationTypeId").val("");
		$("#ApplicationS1QualificationTitle").val("");
		$("#ApplicationQualificationTitle").val("");
		$("#ApplicationHeqcMeetingId").val("");
		$("#ApplicationStatus").val("");
		$("#ApplicationLkpCesm1CodeId").val("");
		$("#ApplicationKeyword").val("");
		$fromDate.val("");
		$toDate.val("");
		$("#ApplicationReviewUserId").val("");
	});
	
	var $errorMessage = $("span.errorMessage"),
		toDateTime = new Date($toDate.val()),
		fromDateTime = new Date($fromDate.val());
	
	$errorMessage.hide();

	if(toDateTime.getTime() < fromDateTime.getTime()){
		$toDate.css("border", "red solid 1px");
		$errorMessage.show();
	}
	else{
		$toDate.css("border", "none");
		$errorMessage.hide();
	}
	
	$toDate.change(function(){
		checkDate();
	});
	
	$fromDate.change(function(){
		checkDate();
	});
	
	function checkDate(){
		toDateTime = new Date($toDate.val()),
		fromDateTime = new Date($fromDate.val());
		
		if(toDateTime.getTime() < fromDateTime.getTime()){
			$toDate.css("border", "red solid 1px");
			$errorMessage.show();
		}
		else{
			$toDate.css("border", "none");
			$errorMessage.hide();
		}
	}
	
});
</script>