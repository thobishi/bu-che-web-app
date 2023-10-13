<div id="<?php echo $report['slug']?>">
	<?php echo $this->element('reports/html/' . Inflector::tableize($report['model']) . '/' . $report['element']);?>
</div>
