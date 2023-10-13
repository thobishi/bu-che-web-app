<?php
	$fieldsToShow = $this->Heqf->{$viewType};
	$sites = $this->Heqf->sites;
	$saqaFields = $this->Heqf->saqaFields;
?>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<h2 class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">The following fields appear in section 1 and section 2</span>
	</h2>
	<table>
		<tr>
			<th width="20%">
				Field
			</th>
			<th width="40%">
				Section 1
			</th>
			<th width="40%">
				Section 2
			</th>
		</tr>
	<?php
		$i = 0;
		foreach ($fieldsToShow as $heading => $fields) {
			$class = '';
			if ($i++ % 2 == 0) {
				$class .= ' altrow';
			}
			if (!empty($fields)) {
				echo '<tr class="' . $class . '"><td>' . $heading . '</td>';
				echo !empty($fields['section 1']) ? '<td>' . $this->Heqf->displayField($fields['section 1'], $information, $institutionType) . '</td>' : '<td class="section-alert">Only section 2</td>';
				echo !empty($fields['section 2']) ? '<td>' . $this->Heqf->displayField($fields['section 2'], $information, $institutionType) . '</td>' : '<td class="section-alert">Only section 1</td>';
				echo '</tr>';
			}
		}
		$show = '';
		foreach ($sites as $heading => $fields) {
			$class = '';
			$foundSite = 0;
			if ($i++ % 2 == 0) {
				$class .= ' altrow';
			}
			$row = '';
			$row .= '<tr class="' . $class . '"><td>' . $heading . '</td>';
			foreach ($fields as $field) {
				$siteValue = $this->Heqf->getSites($field, $information, $institutionType);
				$row .= '<td>' . $siteValue . '</td>';
				$foundSite = (!empty($siteValue)) ? $foundSite + 1 : $foundSite;
			}
			$row .= '</tr>';
			echo ($foundSite > 0) ? $row : '';
		}
	?>
	</table>
</div>

<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<h2 class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">The relevant SAQA fields are listed below</span>
	</h2>
	<table>
		<tr>
			<th colspan="2">
				SAQA fields
			</th>
		</tr>
		<tr>
			<th width="20%">
				Field
			</th>
			<th>
				Description
			</th>
		</tr>
			<tr>
				<td>
					SAQA qualification ID <br /> <span style="color:grey;font-size:10px;">(If a SAQA qualification ID is given then the other fields do not need to be completed)</span>
				</td>
				<td>
					<?php
						echo !empty($information['HeqfQualification']['s1_saqa_qualification_id']) ? $information['HeqfQualification']['s1_saqa_qualification_id'] : $information['HeqfQualification']['saqa_qualification_id'];
					?>
				</td>
			</tr>
	<?php
		$i = 0;
		foreach ($saqaFields as $field => $label) {
			$class = '';
			if ($i++ % 2 == 0) {
				$class .= ' altrow';
			}
			echo '<tr class="' . $class . '"><td>' . $label . '</td>';
			echo '<td>' . $this->Heqf->displayField($field, $information, $institutionType) . '</td>';
			echo '</tr>';
		}
	?>
	</table>
</div>