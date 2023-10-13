<?php
	$url = array_merge(
		array(
			'controller' => 'process',
			'action' => 'perform_action',
			'process-slug' => $currentProcess['Process']['slug']
		),
		$this->params['named']
	);
	echo $this->Form->create('Process', array(
		'id' => 'Process',
		'url' => $url
	));
	echo $this->element('actions/' . $currentProcess['Process']['slug'] . '/extra/selected_list');
	echo $this->element('actions/' . $currentProcess['Process']['slug'] . '/' . $this->params['form']['action']);

	echo $this->Form->input('selected', array('type' => 'hidden', 'value' => json_encode($selected)));
	echo $this->Form->end();