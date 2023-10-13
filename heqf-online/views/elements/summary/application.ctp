<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">Application summary</span>
	</div>
	<div class="ui-dialog-content ui-widget-content application_heading">
		<?php
			if (isset($processData) && !empty($processData)) {
				$instName = $processData['Institution']['hei_name'] . ' (' . $processData['Institution']['hei_code'] . ')';
				echo 'Institution <strong>' . $instName . '</strong><br />';
				$title = (!empty($processData['HeqfQualification']['qualification_title'])) ? $processData['HeqfQualification']['qualification_title'] : $processData['HeqfQualification']['s1_qualification_title'];
				echo 'Qualification reference <strong>' . $title . ' ('.$processData['HeqfQualification']['s1_qualification_reference_no'].')</strong>';
			} elseif (!empty($this->data)) {
				$instName = $this->data['Institution']['hei_name'];
				echo 'Institution <strong>' . $instName . '</strong><br />';
				$title = (!empty($this->data['HeqfQualification']['qualification_title'])) ? $this->data['HeqfQualification']['qualification_title'] : $this->data['HeqfQualification']['s1_qualification_title'];
				echo 'Qualification reference <strong>' . $title . ' ('.$this->data['HeqfQualification']['s1_qualification_reference_no'].')</strong>';
			}
		?>
	</div>
</div>