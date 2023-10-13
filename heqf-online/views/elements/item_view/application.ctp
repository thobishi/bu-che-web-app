<?php
	$institutionType = '2';
	$information = array();
	if(isset($processData) && !empty($processData)){
		$information = $processData;
		if(!empty($processData['Institution'])){
			$institutionType = $processData['Institution']['priv_publ'];
		}
	}
	elseif(isset($this->data) && !empty($this->data)){
		$information = $this->data;
		if(!empty($this->data['Institution'])){
			$institutionType = $this->data['Institution']['priv_publ'];
		}
	}
	
	
?>

<?php
if(isset($this->params['sectionView'])){
	switch($this->params['sectionView']){
		case 'comments':
			echo $this->element('item_view/viewComments');
			break;
		case 'commentHistory':
			echo $this->element('item_view/commentHistory');
			break;
		case 'evaluation':
			echo $this->element('item_view/evaluationHistory', array('information' => $information, 'institutionType' => $institutionType));
			break;
	}
}
else{
	if(!empty($information)){
		$viewQualTemplate = array(
			'A' => '/AandBView',
			'B' => '/AandBView',
			'C' => '/CView',
		);
		
		$viewInstTemplate = array(
			'1' => '/private',
			'2' => '/public',
		);
		echo (isset($information['HeqfQualification']['s1_lkp_heqf_align_id']) && !empty($information['HeqfQualification']['s1_lkp_heqf_align_id'])) ? $this->element('viewTemplate' . $viewInstTemplate[$institutionType] .  $viewQualTemplate[$information['HeqfQualification']['s1_lkp_heqf_align_id']], array('information' => $information, 'institutionType' => $institutionType)) : '';
	}
}
?>