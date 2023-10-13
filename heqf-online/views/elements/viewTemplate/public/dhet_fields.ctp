<?php $dhetFields = $this->Heqf->dhetFields; ?>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all application-summary">
	<h2 class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="application_heading">The relevant DHET fields are listed below</span>
	</h2>
	<table>
		<tr>
			<th colspan="3">
				DHET fields
			</th>
		</tr>
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
		foreach ($dhetFields as $heading => $fields) {
			$class = '';
			if ($i++ % 2 == 0) {
				$class .= ' altrow';
			}
			echo '<tr class="' . $class . '"><td>' . $heading . '</td>';
			foreach ($fields as $field) {
				echo '<td>' . $this->Heqf->displayField($field, $information, $institutionType) . '</td>';
			}
			echo '</tr>';
		}
	?>
	</table>
</div>