<div class="listViews">
	<h2><?php __('List of Modules');?></h2>
</div>

<?php echo $this->element('information/modules_administrator'); ?>

<div class="bulkButtons">
	<?php
		echo $this->Html->link('Export institution modules to excel', array(
			'action' => 'export', 'controller' => 'institution_modules', 'ext' => 'xlsx'
		));
		echo $this->Html->link('Export qualification modules to excel', array(
			'action' => 'export', 'controller' => 'heqf_qualification_modules', 'ext' => 'xlsx'
		));
	?>
</div>

<table class="module-table">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('Reference', 'InstitutionModule.reference') ?></th>
			<th><?php echo $this->Paginator->sort('Name', 'InstitutionModule.title') ?></th>
			<th><?php echo $this->Paginator->sort('NQF Level', 'InstitutionModule.nqf_level_id') ?></th>
			<th><?php echo $this->Paginator->sort('Credits', 'InstitutionModule.credits') ?></th>
		</tr>		
	</thead>
	<tbody>
		<?php
			$tableRows = array();
			foreach ($list as $key => $module) {
				$tableRows[] = array(
					$module['InstitutionModule']['reference'],
					$module['InstitutionModule']['title'],
					$module['InstitutionModule']['nqf_level_id'],
					$module['InstitutionModule']['credits']
				);
			}
			echo $this->Html->tableCells($tableRows);
		?>
	</tbody>
</table>

<?php
	if ($this->AuthLinks->checkPermission('create', 'module', 'process')) {
		$sidebar[] = $this->Html->link('Download template for bulk import of all institution modules', array('action' => '	download_template', 'controller' => 'institution_modules'));
		$sidebar[] = $this->Html->link('Download template for bulk import of modules for qualifications', array('action' => 'download_template', 'controller' => 'heqf_qualification_modules'));
		$sidebar[] = $this->AuthLinks->link('Bulk import of all institution modules', array('action' => 'import', 'controller' => 'institution_modules'));
		$sidebar[] = $this->AuthLinks->link('Bulk import of modules for qualifications', array('action' => 'import', 'controller' => 'heqf_qualification_modules'));
	}

	$this->set('sidebar', $sidebar);