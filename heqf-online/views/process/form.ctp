<?php
	$layout = array('summary', 'fieldset');
	$quickSave = true;
	$sidebar = array();

	$sidebar[] = $this->Html->link(
		'Close and return to list', 
		array(
			'action' => 'close', 
			'flow-slug' => $currentFlow['Flow']['slug'], 
			'process-slug' => $currentProcess['Process']['slug']
		), 
		array(
			'id' => 'closeForm',
			'class' => 'Return'
	));
	
	if(isset($currentProcess['Process']) && !empty($currentProcess['Process'])){
		switch($currentProcess['Process']['slug']){
			case 'review':
				$sidebar[] = '<li>' . $this->Html->link(__('View application', true), array('controller' => 'process', 'action' => 'view','process-slug' => 'application', 'id' => $this->data['Application']['id']),  array('target' => '_blank','escape' => false)) . '</li>';
			case 'evaluate' :
			case 'checklist' :
			case 'evaluate-cat-b':
				if ($this->params['url']['ext'] !== 'pdf' || $this->params['url']['ext'] !== 'xlsx') {
					$processSlug = ($currentProcess['Process']['slug'] == 'evaluate-cat-b') ? 'evaluate' : $currentProcess['Process']['slug'];
					$sidebar[] = '<li>' . $this->Html->link(__('Download application as PDF', true), array('controller' => 'process', 'action' => 'view', 'process-slug' => $processSlug, 'id' => $this->data['Application']['id'], 'ext' => 'pdf')) . '</li>';
					if ($currentProcess['Process']['slug'] == 'evaluate-cat-b') {
						$sidebar[] = '<li>' . $this->Html->link(__('View application', true), array('controller' => 'process', 'action' => 'view','process-slug' => 'application', 'id' => $this->data['Application']['id']),  array('target' => '_blank','escape' => false)) . '</li>';
					}
				}
				if ($currentProcess['Process']['slug'] == 'evaluate') {
					$layout = array('fieldset', 'summary');
					$quickSave = false;
				}				

				break;
								
		}
	}
?>

<?php
	foreach($layout as $layoutElement){
		echo $this->element('process/' . $layoutElement);
	}
?>

<?php
	$this->Html->script('process/form', array('inline' => false));

	if(isset($edit)) {
		if($quickSave){
			$sidebar[] = $this->Html->link(
				'Quick save', 
				array(
					'action' => 'form', 
					'flow-slug' => $currentFlow['Flow']['slug'], 
					'process-slug' => $currentProcess['Process']['slug']
				),
				array(
					'class' => 'SaveCont'
				)
			);
		}
		
		foreach($currentProcess['Flow'] as $flow) {
			$flowLink = '';
			if($currentFlow['Flow']['slug'] != $flow['slug']) {
				$flowLink .= $this->Html->link(
						$flow['name'], 
						array(
							'action' => 'form', 
							'process-slug' => $currentProcess['Process']['slug'], 
							'flow-slug' => $currentFlow['Flow']['slug'], 
							'to-flow' => $flow['slug']
						),
						array(
							'class' => $flow['slug']
						)
				);
			}
			else {
				$flowLink .= $currentFlow['Flow']['name'];
			}
			$flowLink .= '<div class="description">'.$flow['description'].'</div>';
			$sidebar['Sections'][] = $flowLink;
		}
		
		if(!empty($this->data['Application']) && $this->data['Application']['review_error']){
			$sidebar[] = '<li>' . $this->Html->link(
				__('View comments', true),
				array(
					'controller' => 'process', 
					'action' => 'view', 
					'process-slug' => 'application', 
					'id' => $this->data['Application']['id'],
					'sectionView' => 'comments'
				),
				array(
					'class' => 'dialogViewLink compare',
					'rel' => 'comments',
					'target' => '_blank',
					'id' => 'commentsLink'
				)
			) . '</li>';
		}
	}
	
	$this->set('sidebar', $sidebar);
?>
