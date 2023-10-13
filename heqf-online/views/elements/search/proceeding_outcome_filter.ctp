<div id="advanced_search">
	<fieldset><legend>Advanced Search</legend>
	<?php
		echo $this->Form->input('Institution.search.institution', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'options' => $institutionList));

		echo $this->Form->input('Institution.search.meeting_date', array('label' => 'HEQC meeting dates', 'empty' => 'Select', 'type' => 'select', 'options' => $heqcMeetingList));

		echo $this->Form->submit('Search', array('id' => 'searchButton', 'value' => 'advancedSearch', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear search</a>'));
	?>
	</fieldset>
</div>