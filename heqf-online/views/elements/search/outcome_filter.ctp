<div id="advanced_search">
	<fieldset><legend>Advanced Search</legend>
	<?php
		echo $this->Form->input('Process.search.institution', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'options' => $Institution));

		echo $this->Form->input('Process.search.meeting_date', array('label' => 'HEQC meeting date', 'empty' => 'Select', 'type' => 'select', 'options' => $HeqcMeeting));

		echo $this->Form->submit('Search', array('id' => 'searchButton', 'value' => 'advancedSearch', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear search</a>'));
	?>
	</fieldset>
</div>