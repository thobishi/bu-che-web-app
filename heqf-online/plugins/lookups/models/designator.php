<?php
class Designator extends LookupsAppModel {

	public $displayField = 'designator_desc';

	public $order = 'id';

	private	$__valueCache;

	public function getValues() {
		if (empty($this->__valueCache)) {
			$this->__valueCache = $this->find('list', array(
				'fields' => array('Designator.id', 'Designator.designator_desc')
			));
		}

		return $this->__valueCache;
	}
}