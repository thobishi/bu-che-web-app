<?php
	echo $this->element('summary/' . $currentProcess['Process']['slug']);
	echo $this->element('item_view/' . $currentProcess['Process']['slug']);
	
	$notDownloadable = array('outcome');
	$sidebar = array();
	$sidebar[] = '<li>'. $this->Html->link('Close and return to list', array('action' => 'close', 'flow-slug' => $currentFlow['Flow']['slug'], 'process-slug' => $currentProcess['Process']['slug']), array('id' => 'closeForm')).'</li>';
	if (($this->params['url']['ext'] !== 'pdf' || $this->params['url']['ext'] !== 'xlsx') && !in_array($currentProcess['Process']['slug'], $notDownloadable)) {
		$sidebar[] = '<li>'. $this->Html->link(__('Download as PDF', true), array('controller' => 'process', 'action' => 'view', 'process-slug' => $currentProcess['Process']['slug'], 'id' => $processData['Application']['id'], 'ext' => 'pdf')).'</li>';
	}
	
	$this->set('sidebar', $sidebar);
?>
