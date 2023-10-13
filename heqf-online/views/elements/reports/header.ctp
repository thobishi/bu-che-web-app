<?php if($this->params['url']['ext'] !== 'pdf' || $this->params['url']['ext'] !== 'xlsx') { ?>
<ul class="actions reportActions">
	<?php 
	echo $this->Html->link(__('Download Excel report', true), array_merge($this->params['named'], array('ext' => 'xlsx', $this->params['pass'][0])));
	echo $this->Html->link(__('Download PDF report', true), array_merge($this->params['named'], array('ext' => 'pdf', $this->params['pass'][0])));
	?> 
</ul>
<div class="clear"></div>
<?php
	if(!empty($filters)) {
		echo $this->element('search', array(
			'url' => array('controller' => 'reports', 'action' => 'index', $this->params['pass'][0]),
			'model' => $report['model'],
			'advancedOnly' => true,
			'searchText' => 'Filter ' . strtolower($report['name']),
			'clearSearch' => false,
			'advanced' => array_merge(array(
				'legend' => 'Filter ' . strtolower($report['name']),
			), $filters)
		));
	}
}
?>