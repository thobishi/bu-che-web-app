<?php

	if (!empty($applications)) {
		echo $this->Form->input('Application.heqc_meeting', array('label' => 'Please select the HEQC meeting for these applications', 'options' => $HeqcMeeting, 'empty' => 'Select'));
	}
?>