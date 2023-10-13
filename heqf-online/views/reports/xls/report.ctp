<?php
	echo $this->element('reports/xls/' . Inflector::tableize($report['model']) . '/' . $report['element']);
	
	$this->set('filename', $this->viewVars['filename'] . ' - Generated on ' . date('d F Y'));
?>
