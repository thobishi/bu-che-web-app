<div class="dashboard">

<?php if($this->params['url']['ext'] !== 'pdf' || $this->params['url']['ext'] !== 'xlsx') { ?>
		<ul class="actions reportActions">
			<?php 
			echo $this->Html->link(__('Download Excel report', true), array_merge($this->params['named'], array('ext' => 'xlsx', $this->params['pass'][0])));
			?> 
		</ul>
		<div class="clear"></div>
<?php
}
	$this->set('title_for_layout', 'HEQSF data dump');
?>
	<h2>Data dump</h2>

<?php
	echo '<div style="clear:both;"></div>';
	echo $this->element('search/data_dump_filter', array(
			'url' => array('controller' => 'reports', 'action' => 'index', $this->params['pass'][0]),
			'model' => $report['model'],
			'advancedOnly' => true,
			'searchText' => 'Filter ' . strtolower($report['name']),
			'clearSearch' => false
		)
	);
?>
	
	<p>Download the complete HEQSF data dump.</p>
</div>