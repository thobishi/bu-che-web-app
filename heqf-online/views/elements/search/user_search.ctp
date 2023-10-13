<div id="advanced_search">
	<fieldset><legend>Advanced search</legend>
	<?php
		$Status = array(0 => __('Deactivated', true), 1 => __('Active', true));
		echo $this->Form->create('User', array('id' => 'search'));
		echo $this->Form->input('institution_id', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'default' => $defaults['institution_id']));
		echo $this->Form->input('role', array('label' => 'Role', 'empty' => 'Select', 'type' => 'select', 'default' => $defaults['role_id']));
		echo $this->Form->input('status', array('label' => 'Status', 'empty' => 'All users', 'type' => 'select', 'options' => $Status));

		$cancelLink = $this->Html->link('Clear filter', $url, array('id' => 'clearSearchLink', 'class' => 'searchLink'));
		echo $this->Form->submit('Filter', array('after' => '<span class="separator"> | </span>' . $cancelLink));
		/*echo $this->Form->submit('Filter', array('id' => 'searchButton', 'value' => 'advancedSearch', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear filter</a>'));*/
		echo $this->Form->end();
	?>
	</fieldset>
</div>
<script>
$(function() {
	var $advanced_search = $("#advanced_search");
	var $searchLink = $("#searchLink");
	var $clearSearchLink = $("#clearSearchLink");
	$advanced_search.hide();
	$searchLink.click(function(e){
		e.preventDefault();
		$advanced_search.toggle("Fast");
		if($searchLink.html() == 'Advanced search'){
			$searchLink.html("Hide advanced search");
		}
		else{
			$searchLink.html("Advanced search");
		}
	});
	
	/*$clearSearchLink.click(function(e){
		e.preventDefault();
		$("#UserInstitutionId").val("");
		$("#UserRoleId").val("");
		$("#UserStatus").val("");
	});*/
});
</script>