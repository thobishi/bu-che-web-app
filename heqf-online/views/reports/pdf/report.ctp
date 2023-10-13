<?php
	echo $this->element('reports/pdf/' . Inflector::tableize($report['model']) . '/' . $report['element']);
	
	$title_for_layout = $this->getVar('title_for_layout');

	$footer = array(
		'left' => $title_for_layout . ' - ' . date('Y-m-d H:i'),
		'right' => 'Page [page] of [topage]'
	);	
	
	$this->setOption('footer', $footer);
	$this->set('filename', $this->viewVars['filename'] . ' - Generated on ' . date('d F Y'));
?>
