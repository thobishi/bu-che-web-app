<?php echo $this->Form->input('HeqfQualification.id');?>
<?php
	echo $this->element('item_view/application', array('processData' => $this->data));

?>
<div>
<?php echo '<a id="evalLink" href="#">View evaluation form information</a>';
?>
</div>
<div class="Clear">
</div>
<fieldset id="evalInformation"><legend>Evaluation form</legend>
<?php
	echo $this->element('flows/evaluate/evaluate_form', array('processData' => $this->data));
?>
</fieldset>
<script>
$(function() {
	var $evalInformation = $("#evalInformation");
	var $evalLink = $("#evalLink");
	$evalInformation.hide();
	$evalLink.click(function(e){
		e.preventDefault();
		$evalInformation.toggle("Fast");
		if($evalLink.html() == 'View evaluation form information'){
			$evalLink.html("Hide evaluation form information");
		}
		else{
			$evalLink.html("View evaluation form information");
		}
	});
});
</script>