<?php
	if(!empty($variables['admin'])){
?>
Dear <?php echo $variables['admin']['User']['first_name'] . ' ' . $variables['admin']['User']['last_name']; ?>.

Reviewed applications have been returned to your institution for correction.

Please perform the following steps to access these applications:

	1. Login to http://heqsf-online.che.ac.za/
	2. Click on the "Applications" link
	3. Click on the "Requirements" tab

Kind regards
HEQSF Online	
	
<?php
	}
?>