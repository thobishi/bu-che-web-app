<?php
	if (isset($this->Paginator)) {
		$this->Paginator->options(array(
			'url' => array(
				'process-slug' => $currentProcess['Process']['slug'],
				'action' => 'list_process',
				'controller' => 'process'
			)
		));
	}
	echo $this->element('list_views/' . $currentProcess['Process']['slug']);