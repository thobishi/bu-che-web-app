<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">Application summary</span>
	</div>
	<div class="ui-dialog-content ui-widget-content application_heading">
		<?php
			$instName = $this->data['Institution']['hei_name'];
			echo 'Institution <strong>' . $instName . '</strong><br />';
			$title = (!empty($this->data['HeqfQualification']['qualification_title'])) ? $this->data['HeqfQualification']['qualification_title'] : $this->data['HeqfQualification']['s1_qualification_title'];
			echo 'Qualification reference <strong>' . $title . ' ('.$this->data['HeqfQualification']['s1_qualification_reference_no'].')</strong>';
		?>
	</div>
	<table>
		<tr>
			<th>Qual Ref No</th>
			<th>Qual Title Abbr</th>
			<th>Qual Title</th>
			<th>SAQA Qual ID</th>
			<th>Qual Designator</th>
			<th>Motivation Other Designator</th>
			<th>CESM</th>
			<th>Mode of Delivery</th>
			<th>Prof Class</th>
			<th>NQF Exit Level</th>
			<th>Total Credits</th>
			<th>WIL EL Credits</th>
			<th>Research Credits</th>
			<th>Major Field Of Study</th>
		</tr>
<?php
			if(!empty($this->data['HeqfQualification'])){
				$cesms = $this->Heqf->reportMultiple($this->data['HeqfQualification']['lkp_cesm1_code_id'], $cesm_codes);
				$majors = $this->Heqf->reportMultiple($this->data['HeqfQualification']['hemis_lkp_cesm3_code_id'], $hemis_qualifiers);
?>
		<tr>
			<td><?php echo $this->data['HeqfQualification']['qualification_reference_no']; ?></td>
			<td><?php echo $this->data['HeqfQualification']['qualification_title_short']; ?></td>
			<td><?php echo $this->data['HeqfQualification']['qualification_title']; ?></td>
			<td><?php echo $this->data['HeqfQualification']['saqa_qualification_id']; ?></td>
			<td><?php echo ($this->data['HeqfQualification']['lkp_designator_id'] == 'Oth') ? $this->data['HeqfQualification']['other_designator'] : (isset($designators[$this->data['HeqfQualification']['lkp_designator_id']]) ? $designators[$this->data['HeqfQualification']['lkp_designator_id']] : $this->data['HeqfQualification']['lkp_designator_id']); ?></td>
			<td><?php echo $this->data['HeqfQualification']['motivation_other_designator']; ?></td>
			<td><?php echo $cesms; ?></td>
			<td><?php echo $delivery_modes[$this->data['HeqfQualification']['lkp_delivery_mode_id']]; ?></td>
			<td><?php echo $professional_classes[$this->data['HeqfQualification']['lkp_professional_class_id']]; ?></td>
			<td><?php echo $nqf_levels[$this->data['HeqfQualification']['lkp_nqf_level_id']]; ?></td>
			<td><?php echo $this->data['HeqfQualification']['credits_total']; ?></td>
			<td><?php echo $this->data['HeqfQualification']['wil_el_credits']; ?></td>
			<td><?php echo $this->data['HeqfQualification']['research_credits']; ?></td>
			<td><?php echo $majors; ?></td>
		</tr>
<?php
			}
?>
	</table>
</div>