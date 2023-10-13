<div class="index">
<?php
		$url = array_merge(
			array(
				'controller' => 'process',
				'process-slug' => $currentProcess['Process']['slug']
			),
			$this->params['named']
		);

	if (isset($this->Paginator)) {
		$url['action'] = 'list_process';

		$this->Paginator->options(array(
			'url' => $url
		));
	}

	$url['action'] = 'perform_action';
	echo $this->Form->create('Process', array(
		'url' => $url,
		'id' => 'list-view'
	));
	echo $this->Form->hidden('selected');
	echo $this->element('list_views/' . $currentProcess['Process']['slug']);
	echo $this->Form->end();
	$this->Html->script(array(
			'process/list_process',
			//$currentProcess['Process']['slug'].'/list'
		),
		array(
			'inline' => false
	));
?>
	<span class="ui-helper-hidden" id="searchUrl"><?php $url['action'] = 'list_process'; echo Router::url($url)?></span>
</div>