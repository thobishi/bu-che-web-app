<?php
	if ((!empty($information)) && ($information['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B')) {
		$section3Fields = $this->Heqf->section3Fields;
	?>
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
			<h2 class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
				<span class="application_heading">Section 3 - Questions</span>
			</h2>
		<?php
			foreach ($section3Fields as $fieldName => $title) {
				if (isset($information['HeqfQualification'][$fieldName])) {
					echo $this->Heqf->displaySectionThree($fieldName, $information);
				}
			}
		?>
		</div>
	<?php
	}