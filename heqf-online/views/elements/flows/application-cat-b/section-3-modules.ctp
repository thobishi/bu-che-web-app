<?php
	echo $this->Form->input('HeqfQualification.id');

	echo '<div class="input required"><label>' . $this->Heqf->section3Fields['s3_modules'] . '</label></div>';

	if (!empty($this->data['HeqfQualification']['HeqfQualificationModule'])) {
		echo $this->element('grids/section_3/modules', array('modules' => $this->data['HeqfQualification']['HeqfQualificationModule']));
	}

	if ($numberInstModules > 0) {
		$this->Html->script('application/section-3-B-modules', array('inline' => false));
		echo $this->element('information/modules');
	?>
	<div class="bulkButtons">
		<?php
			$exportHeading = count($this->data['HeqfQualification']['HeqfQualificationModule']) ?
				'Export qualification modules to excel' :
				'Download excel template for qualification modules';
			echo $this->Html->link($exportHeading, array(
				'action' => 'export', 'controller' => 'heqf_qualification_modules', 'ext' => 'xlsx', 'qual' => $this->data['HeqfQualification']['id']
			));
			echo $this->Html->link('Import qualification modules from excel', array(
				'action' => 'import', 'controller' => 'heqf_qualification_modules', 'qual' => $this->data['HeqfQualification']['id']
			), array('class' => 'import-modules'));
		?>
	</div>
	<?php
	} else {
		echo $this->element('information/no_modules');
	}
