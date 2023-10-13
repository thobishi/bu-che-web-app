<div id="advanced_search">
	<fieldset><legend>Advanced Search</legend>
	<?php
		echo $this->Form->input('Process.search.categoryChe', array('label' => 'Proposed HEQSF category', 'empty' => 'Select', 'type' => 'select', 'options' => $AppHeqfAlign));
		echo $this->Form->input('Process.search.categoryInst', array('label' => 'Institution alignment category', 'empty' => 'Select', 'type' => 'select', 'options' => $AppHeqfAlign));
		echo $this->Form->input('Process.search.institution', array('label' => 'Institution', 'empty' => 'Select', 'type' => 'select', 'options' => $Institution));
		echo $this->Form->input('Process.search.qual_type', array('label' => 'Section 2 Qualification type', 'empty' => 'Select', 'type' => 'select', 'options' => $QualificationType));
		echo $this->Form->submit('Search', array('id' => 'searchButton', 'value' => 'search', 'after' => '<span class="separator">|</span><a class="searchLink" href="#" id="clearSearchLink">Clear search</a>'));
		echo $this->Form->hidden('Process.search.clear', array('value' => 'false'));
	?>
	</fieldset>
</div>