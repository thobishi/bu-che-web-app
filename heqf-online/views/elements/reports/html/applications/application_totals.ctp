<div class="list_view_table">
<?php
	if ($this->params['url']['ext'] !== 'pdf' || $this->params['url']['ext'] !== 'xlsx') {
	?>
		<ul class="actions reportActions">
			<?php 
			echo $this->Html->link(__('Download PDF report', true), array_merge($this->params['named'], array('ext' => 'pdf', $this->params['pass'][0])));
			?> 
		</ul>
		<div class="clear"></div>
	<?php
	}
	$this->set('title_for_layout', 'HEQSF totals report');
	$institution = (isset($this->params['named']['institution_id']) && isset($Institution[$this->params['named']['institution_id']])) ? ' - ' . $Institution[$this->params['named']['institution_id']] : '';
?>
<h2>HEQSF totals report<?php echo $institution; ?></h2>
<?php
	echo '<div style="clear:both;"></div>';
	echo $this->element('search/institution_offerings_filter', array(
			'url' => array('controller' => 'reports', 'action' => 'index', $this->params['pass'][0]),
			'model' => $report['model'],
			'advancedOnly' => true,
			'searchText' => 'Filter ' . strtolower($report['name']),
			'clearSearch' => false
		)
	);

	echo $this->element('reports/html/application_totals_content');
?>
</div>