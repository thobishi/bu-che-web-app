<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">Application summary</span>
	</div>
	<div class="ui-dialog-content ui-widget-content application_heading">
		<?php
			if(isset($processData)){
				$instName = $processData['Institution']['hei_name'];
				echo 'Institution <strong>' . $instName . '</strong><br />';
				$title = (!empty($processData['HeqfQualification']['qualification_title'])) ? $processData['HeqfQualification']['qualification_title'] : $processData['HeqfQualification']['s1_qualification_title'];
				echo 'Qualification reference <strong>' . $title . ' ('.$processData['HeqfQualification']['s1_qualification_reference_no'].')</strong>';				
			}else{
				$instName = $this->data['Institution']['hei_name'];
				echo 'Institution <strong>' . $instName . '</strong><br />';
				$title = (!empty($this->data['HeqfQualification']['qualification_title'])) ? $this->data['HeqfQualification']['qualification_title'] : $this->data['HeqfQualification']['s1_qualification_title'];
				echo 'Qualification reference <strong>' . $title . ' ('.$this->data['HeqfQualification']['s1_qualification_reference_no'].')</strong>';
			}
		?>
	</div>
</div>
<?php
	$itemData = isset($processData) ? $processData : $this->data;
	if ($this->params['url']['ext'] == 'pdf' || $this->params['url']['ext'] == 'xlsx') {
		echo $this->element('item_view/application', array('processData' =>  $itemData));
	}
?>