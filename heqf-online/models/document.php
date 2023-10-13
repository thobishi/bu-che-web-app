<?php
class Document extends AppModel {
	public $name = 'Document';
	public function findDocument($docSlug) {
		$document = $this->findBySlug($docSlug);

		if(!$document) {
			throw new Exception(__('The document you requested does not exist.', true));
		}

		return $document['Document'];
	}
	
}