<?php
	$privateC = $this->Heqf->privateC;
?>
	<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span class="application_heading">The following fields appear in section 1</span>
		</div>
	<table>
		<tr>
			<th width="20%">
				Field
			</th>
			<th width="40%">
				Section 1
			</th>
		</tr>
	<?php
		$i = 0;
		foreach($privateC as $heading => $field){
			$class = '';
			if ($i++ % 2 == 0) {
				$class .= ' altrow';
			}
			echo '<tr class="' . $class . '"><td>' . $heading . '</td>';
			echo '<td>' . $this->Heqf->displayField($field, $information, $institutionType) . '</td>';
			echo '</tr>';
		}
	?>
	</table>
	</div>