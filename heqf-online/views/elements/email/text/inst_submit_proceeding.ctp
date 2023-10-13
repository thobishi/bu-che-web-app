
<?php
	
	echo "Dear Adminitator" . "\n\n";
	echo "The following Representation(s)/Deferral(s) have been submitted to CHE" . "\n\n";
		
	echo 'Number of Programmes: ' . $variables['numberOfApplications'] . "\n";
	$applicationCount = count($variables['data']) - 1;
	foreach ($variables['data'] as $instName => $applications) {
		echo "Institution: " . $instName . "\n";
		foreach ($applications as $application) {
			echo "Qualification Title: ". $application['HeqfQualification']['qualification_title'] . "\n";
			echo "Qualification Reference: " . $application['HeqfQualification']['s1_qualification_reference_no'] . "\n" ;
		}
		echo ($instName != end($variables['data'])) ? "\n" : '';		
	}	
?>
Kind regards,

HEQSF online system 
Directorate: Accreditation 
Council on Higher Education 
E-mail: heqsfonline@che.ac.za 

