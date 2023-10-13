<div id="<?php echo $document['slug']?>">
	<?php echo $this->element('documents/doc/' . Inflector::tableize($document['model']) . '/' . $document['element']);?>
</div>
