<?php
	$url = array_merge(
		array(
			'controller' => 'institutions',
			'action' => 'perform_action',
		),
		$this->params['named']
	);
	echo $this->Form->create('Institution', array(
		'id' => 'Process',
		'url' => $url
	));
	echo $this->element('actions/institutions/extra/selected_list');
	
	echo $this->Form->input('selected', array('type' => 'hidden', 'value' => json_encode($institutions)));
	echo $this->Form->end();