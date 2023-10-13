
<?php
	$checklistingEmail = false;
	if(!empty($variables['admin'])){
?>
Dear <?php echo $variables['admin']['User']['first_name'] . ' ' . $variables['admin']['User']['last_name'] . "\n" ; ?>
<?php

	}

?>

<?php
	foreach ($variables['current'] as $key => $value) {
		if($value['Application']['checklisting_status_id'] == 'Return' && $value['Application']['application_status'] =='Checklisting' && $value['Application']['checklisting_comments'] > ''){
			$checklistingEmail = true;
		}
	}

	$applicationCount = count($variables['current']) - 1;
	foreach ($variables['current'] as $key => $value) {
		echo "Qualification Reference: " . $value['HeqfQualification']['s1_qualification_reference_no'] . "\n" ;
		echo "Qualification Title:  ". $value['HeqfQualification']['qualification_title'] . "\n";
		echo ($key < $applicationCount) ? "\n" : '';		
	}


	if($checklistingEmail){
?>

The Accreditation Directorate has screened the above submission as part of HEQSF Category B alignment. As a result, the following corrections are required to be made before the submission can be evaluated:

<?php 
	 foreach ($variables['current'] as $key => $value) {
		echo "Corrections for (" . $value['HeqfQualification']['s1_qualification_reference_no'] . ") : ". $value['Application']['checklisting_comments'] . "\n";
	 }

?>

Please ensure that these corrections are completed within 10 working days of receipt of this e-mail, and the application resubmitted to the CHE via the HEQSF-online system.
<?php
	}else{
		echo "\nPlease Note that the above submission(s) has/have been returned to you. \n";
		echo "\nPlease ensure that any corrections are completed within 10 working days of receipt of this e-mail, and the application(s) resubmitted to the CHE via the HEQSF-online system. \n";
	}
?> 

Should you have any concerns or queries in this regard, please contact heqsfonline@che.ac.za.
 
Regards
 
Fundiswa Kanise
Directorate: Accreditation
Council on Higher Education
E-mail: heqsfonline@che.ac.za

