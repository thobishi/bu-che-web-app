<div class="dashboard">

<?php if($this->params['url']['ext'] !== 'pdf' || $this->params['url']['ext'] !== 'xlsx') { ?>
		<ul class="actions reportActions">
			<?php 
			echo $this->Html->link(__('Download Excel report', true), array_merge($this->params['named'], array('ext' => 'xlsx', $this->params['pass'][0])));
			//echo $this->Html->link(__('Download PDF report', true), array_merge($this->params['named'], array('ext' => 'pdf', $this->params['pass'][0])));
			?> 
		</ul>
		<div class="clear"></div>
<?php
}
	$this->set('title_for_layout', 'Complete programme list');
?>
	<h2>Complete programme list</h2>

	<p>Download your institution's complete list of programme information.</p>
</div>