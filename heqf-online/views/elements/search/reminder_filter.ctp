<div id="advanced_search">
	<fieldset><legend>Filter report</legend>
	<?php
		echo $this->Form->create($model, array('url' => $url, 'class' => 'search', 'id' => 'search'));
		
		echo $this->Form->input('s1_lkp_heqf_align_id', array('label' => 'Institution alignment category', 'empty' => 'Select', 'type' => 'select', 'options' => $AppHeqfAlign));
				
		echo $this->Form->input('qualification_title', array('label' => 'Qualification title (Section 2)', 'type' => 'text'));

		echo $this->Form->input('institution_id', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'options' => $Institution));
		
		echo $this->Form->input('status', array('label' => 'Application status', 'empty' => 'Select', 'type' => 'select', 'options' => $Status));

		echo $this->Form->input('currentUser', array('label' => 'User assigned to', 'empty' => 'Select', 'type' => 'select', 'options' => $CurrentUser));

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
		$clearSearchLink = $("#clearSearchLink");
		
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
	
	$clearSearchLink.click(function(e){
		e.preventDefault();
		$("#ApplicationS1LkpHeqfAlignId").val("");
		$("#ApplicationInstitutionId").val("");
		$("#ApplicationQualificationTitle").val("");
		$("#ApplicationStatus").val("");
		$("#ApplicationCurrentUser").val("");
	});
	
});
</script>