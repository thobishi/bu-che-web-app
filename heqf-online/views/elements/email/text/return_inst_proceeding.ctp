
Dear Colleague


<?php
	$applicationCount = count($variables['current']) - 1;
	foreach ($variables['current'] as $key => $value) {
		echo "Qualification Reference: " . $value['HeqfQualification']['s1_qualification_reference_no'] . "\n" ;
		echo "Qualification Title:  ". $value['HeqfQualification']['qualification_title'] . "\n";
		echo ($key < $applicationCount) ? "\n" : '';		
	}

	echo "\nPlease note that the above programme(s) has/have been returned to you for review and resubmission. \n";
	echo "\nPlease ensure that the Representation(s)/Deferral(s) document required as part of this resubmission is uploaded within 25 working days of receipt of this e-mail, and the Representation/Deferral resubmitted to the CHE via the HEQSF-online system. \n";
?> 

Should you have any concerns or queries in this regard, please contact heqsfonline@che.ac.za.
 
Kind Regards
 
Directorate: Accreditation 
Council on Higher Education 
E-mail: heqsfonline@che.ac.za

