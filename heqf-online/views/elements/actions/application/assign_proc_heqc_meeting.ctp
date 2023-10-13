<?php

	if (!empty($applications)) {
		echo $this->Form->input('LastReviewiedProceeding.heqc_meeting_id', array('label' => 'Please select the HEQC meeting for these proceedings', 'options' => $HeqcMeeting, 'empty' => 'Select'));
	}
?>