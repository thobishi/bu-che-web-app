<div id="<?php echo $document['slug']?>">
	<?php echo $this->element('documents/docx/' . Inflector::tableize($document['model']) . '/' . $document['element']);?>
</div>
