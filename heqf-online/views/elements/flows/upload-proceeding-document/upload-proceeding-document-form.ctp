<?php
	echo $this->Form->hidden('Proceeding.id');

	$proceedingType = $this->Heqf->getProceedingTypeDesc($this->data['Proceeding']['proceeding_type_id']);
	
	echo $this->Form->input('Proceeding.proc_document', array('type' => 'file', 'label' => $proceedingType . ' Document'));

	$this->Heqf->showProceedingFile($this->data['Proceeding']['proc_document'], 'View Uploaded ' . $proceedingType, $this->data['Institution']['hei_code']);