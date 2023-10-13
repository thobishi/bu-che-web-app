<?php
	$institution = (isset($this->params['named']['institution_id']) && isset($Institution[$this->params['named']['institution_id']])) ? ' - ' . $Institution[$this->params['named']['institution_id']] : '';
	$title = 'HEQSF totals report' . $institution;
	$this->set('title_for_layout', $title);
	$this->set('filename',  $title);
	
	echo $this->element('reports/html/application_totals_content');
?>