<div class="applicationList">
	<?php
		if(!empty($applications)) {
			$applications = Set::combine($applications, '{n}.HeqfQualification.id', array('<strong>{0}</strong> - {1}', '{n}.HeqfQualification.s1_qualification_reference_no', '{n}.HeqfQualification.s1_qualification_title'));

			echo '<h4>'.$listHeading.'</h4>';
			echo $this->Html->nestedList($applications);
		}
		else {
			echo 'No qualifications will be affected by this action.';
		}
	?>
</div>
