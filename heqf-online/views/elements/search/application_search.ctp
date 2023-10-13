<div id="advanced_search">
	<fieldset><legend>Advanced Search</legend>
	<?php
		$isAdmin = (Auth::checkRole('che_admin')) ? true : false;

		
		if ($isAdmin) {
			echo $this->Form->input('Process.search.s1_qualification_reference_no', array('label' => 'Qualification reference no', 'type' => 'text', 'class' => 'searchInput'));
		}
		if ($isAdmin) {
			echo $this->Form->input('Process.search.categoryChe', array('label' => 'Proposed HEQSF category', 'empty' => 'Select', 'type' => 'select', 'options' => $s1_heqf_aligns));
		}
		echo $this->Form->input('Process.search.categoryInst', array('label' => 'Institution alignment category', 'empty' => 'Select', 'type' => 'select', 'options' => $s1_heqf_aligns));

		echo $this->Form->input('Process.search.status', array('label' => 'Application status', 'empty' => 'Select', 'type' => 'select', 'options' => $fields['status']));

		if ($isAdmin) {
			echo $this->Form->input('Process.search.lkp_proceeding_type_id', array('label' => 'Proceeding type', 'empty' => 'Select', 'type' => 'select', 'options' => $ProceedingType));

			echo $this->Form->input('Process.search.institution', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'options' => $Institution));
		}
		echo $this->Form->input('Process.search.qual_type', array('label' => 'Section 2 Qualification type', 'empty' => 'Select', 'type' => 'select', 'options' => $qualification_types));

		if ($isAdmin) {
			echo $this->Form->input('Process.search.meeting_date', array('label' => 'Application HEQC meeting date', 'empty' => 'Select', 'type' => 'select', 'options' => $HeqcMeeting));
			echo $this->Form->input('Process.search.proceeding_meeting_date', array('label' => 'Proceeding HEQC meeting date', 'empty' => 'Select', 'type' => 'select', 'options' => $HeqcMeeting));
		}

		echo $this->Form->input('Process.search.submission_from_date', array('label' => 'Submission from date', 'type' => 'text', 'class' => 'searchInput'));

		echo $this->Form->input('Process.search.submission_to_date', array('label' => 'Submission to date', 'type' => 'text', 'class' => 'searchInput', 'after' => '<span class="errorMessage"><br /> The "to" date cannot be smaller than the "from" date.</span>'));
		/*if ($isAdmin) {
			echo $this->Form->input('Process.search.evaluator', array('label' => 'Evaluator', 'empty' => 'Select', 'type' => 'select', 'options' => $fields['evaluator']));
		}*/
		echo $this->Form->input('Process.search.currentUser', array('label' => 'User assigned to', 'empty' => 'Select', 'type' => 'select', 'options' => $fields['currentUser']));

		if ($isAdmin) {
			echo $this->Form->input('Process.search.lkp_outcome_id', array('label' => 'Outcome', 'empty' => 'Select', 'type' => 'select', 'options' => $ReviewOutcome));
		}

		echo $this->Form->input('Process.search.cesm', array('label' => 'CESM', 'empty' => 'Select', 'type' => 'select', 'options' => $cesm1_codes));
		if ($isAdmin) {																																			
			echo $this->Form->input('Process.search.lkp_delivery_mode_id', array('label' => 'Mode of delivery', 'empty' => 'Select', 'type' => 'select', 'options' => $delivery_modes));
		}

		echo $this->Form->input('Process.search.keyword', array('label' => 'Keyword search'));
		
		/*echo $this->Form->input('Process.search.archived', array('label' => 'Archived Qualification', 'empty' => 'Select', 'type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes')));*/

		echo $this->Form->submit('Search', array('id' => 'searchButton', 'value' => 'search', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear search</a>'));
	?>
	</fieldset>
</div>