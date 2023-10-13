<div id="advanced_search">
	<fieldset><legend>Filter report</legend>
	<?php
		$hideModeOddeliveryArr = array('institution-offerings', 'institution-submissions');
		echo $this->Form->create($model, array('url' => $url, 'class' => 'search', 'id' => 'search'));
		echo $this->Form->input('institution_id', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'options' => $Institution));
		if(!Auth::checkRole('inst_admin') /*&& !in_array($this->params['pass'][0], $hideModeOddeliveryArr)*/){
			echo $this->Form->input('lkp_delivery_mode_id', array('label' => 'Mode of delivery', 'empty' => 'Select', 'type' => 'select', 'options' => $DeliveryMode));
		}
		echo $this->Form->submit('Filter', array('id' => 'searchButton', 'value' => 'advancedSearch', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear filter</a>'));
		
		echo $this->Form->end();
	?>
	</fieldset>
</div>
<div style="float:right">
<?php echo '<a id="searchLink" href="#">Hide report filter</a>';
?>
</div>
<br />
<br />
<script>
$(function() {
	var $advanced_search = $("#advanced_search"),
		$searchLink = $("#searchLink"),
		$clearSearchLink = $("#clearSearchLink");
		
	$advanced_search.show();
	$searchLink.click(function(e){
		e.preventDefault();
		$advanced_search.toggle("Fast");
		if($searchLink.html() == 'Hide report filter'){
			$searchLink.html("Report filter");
		}
		else{
			$searchLink.html("Report filter");
		}
	});
	
	$clearSearchLink.click(function(e){
		e.preventDefault();		
		$("#ApplicationLkpDeliveryModeId").val("");
		$("#ApplicationInstitutionId").val("");
	});
});
</script>