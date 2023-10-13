<div class="index">
<?php
		$url = array_merge(
			array(
				'controller' => 'institutions',
			),
			$this->params['named']
		);

	/*if (isset($this->Paginator)) {
		$url['action'] = 'list_process';

		$this->Paginator->options(array(
			'url' => $url
		));
	}*/

	$url['action'] = 'perform_action';
	echo $this->Form->create('Institution', array(
		'url' => $url,
		'id' => 'list-view'
	));
	echo $this->Form->hidden('selected');
	echo $this->element('institutions/list_proceeding_outcomes');
	echo $this->Form->end();
	$this->Html->script(array(
			'institution/list_process',
		),
		array(
			'inline' => false
	));
?>
	<span class="ui-helper-hidden" id="searchUrl"><?php $url['action'] = 'listProceedingOutcomes'; echo Router::url($url)?></span>
</div>