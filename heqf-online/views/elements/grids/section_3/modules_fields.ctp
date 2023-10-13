<td>
	<?php 
		echo $module['InstitutionModule']['title'];
		echo ' <strong>(' . $module['InstitutionModule']['reference'] . ')</strong>';
	?>
</td>
<td>
	<?php echo isset($nqf_levels[$module['InstitutionModule']['nqf_level_id']]) ? $nqf_levels[$module['InstitutionModule']['nqf_level_id']] : $NqfLevel[$module['InstitutionModule']['nqf_level_id']]	?>
</td>
<td>
	<?php echo $module['InstitutionModule']['credits']; ?>
</td>
<td>
	<?php echo $module['year'];	?>
</td>
<td>
	<?php echo $module['compulsory'] ? 'Yes' : 'No';	?>
</td>
<td>
	<?php echo $module['elective'] ? 'Yes' : 'No';	?>
</td>
<td>
	<?php echo isset($ModuleActions[$module['module_action_id']]) ? $ModuleActions[$module['module_action_id']] : $ModuleAction[$module['module_action_id']]	?>
</td>