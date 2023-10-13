<?php

	$title = Inflector::slug($processData['Institution']['hei_name'] .' '. $processData['HeqfQualification']['qualification_title']);
	$this->set('title_for_layout', '');
	$this->set('filename',  $title);	

	echo $this->element('summary/' . $currentProcess['Process']['slug']);
	if($currentProcess['Process']['slug'] == 'application'){
		echo $this->element('item_view/' . $currentProcess['Process']['slug']);
	}
?>
