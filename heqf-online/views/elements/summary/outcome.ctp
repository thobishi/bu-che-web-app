<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">Outcomes summary</span>
	</div>
	<div class="ui-dialog-content ui-widget-content application_heading">
		<?php
			if(!empty($processData)){
				$instName = $processData['Institution']['hei_name'] . ' (' . $processData['Institution']['hei_code'] . ')';
				echo 'Institution <strong>' . $instName . '</strong><br />';
				$meetingDate = (!empty($this->params['named']['date'])) ? $this->params['named']['date'] : '';
				echo 'HEQC meeting date <strong>' . $meetingDate . '</strong><br />';
			}
		?>
	</div>
</div>