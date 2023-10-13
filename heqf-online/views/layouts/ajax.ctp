<?php
	$errorFlash = $this->Session->flash('auth') . $this->Session->flash('error');
	$messageFlash = $this->Session->flash();

	if(!empty($errorFlash) || !empty($messageFlash)) {
		$messageBox = '<div id="flash-messages">';
		if(!empty($errorFlash)) {
			$messageBox .= '<div class="ui-state-error ui-corner-all">';
			$messageBox .= '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>';
			$messageBox .= $errorFlash;
			$messageBox .= '</div>';
		}

		if(!empty($messageFlash)) {
			$messageBox .= '<div class="ui-state-good ui-corner-all">';
			$messageBox .= '<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>';
			$messageBox .= $messageFlash;
			$messageBox .= '</div>';
		}						

		$messageBox .= '</div>';

		echo $messageBox;
	}
?>
<?php echo $content_for_layout; ?>