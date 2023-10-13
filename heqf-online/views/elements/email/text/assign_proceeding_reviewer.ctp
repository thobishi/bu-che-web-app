
<?php
	
	echo "Dear Colleague" . "\n\n";
	echo "Please process the following " . $variables['proceedingDesc']. "(s) which have been assigned to you." . "\n";
	echo "You may access the programme information for the following " . $variables['proceedingDesc']. "(s) in the HEQSF-online Review Portal" . "\n\n";
	echo 'Number of Programmes: ' . $variables['numberOfApplications'] . "\n";

	foreach ($variables['data'] as $instName => $applications) {
		echo "Institution: " . $instName . "\n";
		foreach ($applications as $application) {
			echo "Qualification Title: ". $application['HeqfQualification']['qualification_title'] . "\n";
			echo "Qualification Reference: " . $application['HeqfQualification']['s1_qualification_reference_no'] . "\n" ;
		}
		echo ($instName != end($variables['data'])) ? "\n" : '';		
	}
	echo "\nPlease note that the review is due by " . $variables['proceedingDueDate'];
	echo "\nYou have already been granted access to the HEQSF-online Review Portal. If it is the first time that you are accessing the HEQSF-online Review Portal then please follow the following instructions:\n";
?> 
1) Access the HEQFS-online system via your web browser (http://heqsf-online.che.ac.za/).
2) Click on forgot password, enter your email address and click on Send Password. A password will be sent to you immediately via email.
3) Logon to the system using your email address as username and the password provided.
4) Once logged on click on the menu item Review to access the programme information.

Kind regards

Directorate: Programme Accreditation 
Council on Higher Education 
E-mail: heqsfonline@che.ac.za

