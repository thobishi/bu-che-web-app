<?php echo $this->Form->input('HeqfQualification.id');?>

<?php if(empty($this->validationErrors)) { ?>
<?php } else { ?>
	<table>
		<tr>
			<th colspan="2">
				<?php 
					echo $this->Html->link(
							'Section 1', 
							array(
								'action' => 'form', 
								'process-slug' => $currentProcess['Process']['slug'], 
								'flow-slug' => $currentFlow['Flow']['slug'], 
								'to-flow' => 'section-1-b'
							),
							array(
								'class' => 'processLink'
							)
					);
				?>
			</th>
		</tr>
		<tr>
			<th width="20%">Field</th>
			<th>Error message</th>
		</tr>
		<?php 
			$i = 0;
			foreach($this->Heqf->section1Fields as $fieldName => $fieldLabel) { 
				if(isset($this->validationErrors['HeqfQualification'][$fieldName])) {
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow';
					}
		?>
			<tr <?php echo 'class="'.$class.'"';?>>
				<td><?php echo $fieldLabel; ?></td>
				<td><?php echo $this->validationErrors['HeqfQualification'][$fieldName]; ?></td>
			</tr>
		<?php 	}
			}		
		if(isset($this->data['HeqfQualification']['s1_lkp_heqf_align_id']) && $this->data['HeqfQualification']['s1_lkp_heqf_align_id'] != 'C'){
		?>
		<tr>
			<th colspan="2">
				<?php 
					echo $this->Html->link(
							'Section 2', 
							array(
								'action' => 'form', 
								'process-slug' => $currentProcess['Process']['slug'], 
								'flow-slug' => $currentFlow['Flow']['slug'], 
								'to-flow' => 'section-2-b'
							),
							array(
								'class' => 'processLink'
							)
					);
				?>
			</th>
		</tr>
		<tr>
			<th width="20%">Field</th>
			<th>Error message</th>
		</tr>
		<?php 
			$i = 0;
			foreach($this->Heqf->section2Fields as $fieldName => $fieldLabel) { 
				if(isset($this->validationErrors['HeqfQualification'][$fieldName])) {
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow';
					}				
		?>
			<tr <?php echo 'class="'.$class.'"';?>>
				<td><?php echo $fieldLabel; ?></td>
				<td><?php echo $this->validationErrors['HeqfQualification'][$fieldName]; ?></td>
			</tr>
		<?php 	}
			} 
		}
		
		if(isset($this->data['HeqfQualification']['s1_lkp_heqf_align_id']) && $this->data['HeqfQualification']['s1_lkp_heqf_align_id'] == 'B'){
		?>
		<tr>
			<th colspan="2">
				<?php 
					echo $this->Html->link(
							'Section 3', 
							array(
								'action' => 'form', 
								'process-slug' => $currentProcess['Process']['slug'], 
								'flow-slug' => $currentFlow['Flow']['slug'], 
								'to-flow' => 'section-3-b'
							),
							array(
								'class' => 'processLink'
							)
					);
				?>
			</th>
		</tr>
		<tr>
			<th width="50%">Field</th>
			<th>Error message</th>
		</tr>
		<?php 
			$i = 0;
			foreach($this->Heqf->section3Fields as $fieldName => $fieldLabel) { 
				if(isset($this->validationErrors['HeqfQualification'][$fieldName])) {
					$class = '';
					if ($i++ % 2 == 0) {
						$class = 'altrow';
					}				
		?>
			<tr <?php echo 'class="'.$class.'"';?>>
				<td><?php echo $fieldLabel; ?></td>
				<td><?php echo $this->validationErrors['HeqfQualification'][$fieldName]; ?></td>
			</tr>
		<?php 	}
			} 
		}
		?>
	</table>
<?php } ?>