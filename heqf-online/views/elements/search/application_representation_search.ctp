<div id="advanced_search">
	<fieldset><legend>Advanced Search</legend>
	<?php

		echo $this->Form->input('Process.search.categoryInst', array('label' => 'Institution alignment category', 'empty' => 'Select', 'type' => 'select', 'options' => $AppHeqfAlign));

		echo $this->Form->input('Process.search.status', array('label' => 'Application status', 'empty' => 'Select', 'type' => 'select', 'options' => $fields['status']));

		echo $this->Form->input('Process.search.qual_type', array('label' => 'Section 2 Qualification type', 'empty' => 'Select', 'type' => 'select', 'options' => $QualificationType));

		echo $this->Form->input('Process.search.cesm', array('label' => 'CESM', 'empty' => 'Select', 'type' => 'select', 'options' => $Cesm1Code));

		echo $this->Form->input('Process.search.keyword', array('label' => 'Keyword search'));

		echo $this->Form->submit('Search', array('id' => 'searchButton', 'value' => 'search', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear search</a>'));
	?>
	</fieldset>
</div>