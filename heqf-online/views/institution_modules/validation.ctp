<?php
	$total = count($data);
	$totalFailed = count($validation);
?>
<div class="import-validation">
	<h1>Validation summary</h1>

	<table class="validationSummaryTable">
		<tr>
			<th>
			</th>
			<th>
				Modules
			</th>
		</tr>
		<tr>
			<td>
				Total records in file
			</td>
			<td>
				<?php echo $total;?>
			</td>	
		</tr>
		<tr>
			<td  class="passedRecord">
				Total passed validation
			</td>
			<td  class="passedRecord">
				<?php echo $total - $totalFailed;?>
			</td>	
		</tr>
		<tr>
			<td class="coreRecordEven">
				Total failed - These will not be imported
			</td>
			<td class="coreRecordEven">
				<?php echo $totalFailed;?>
			</td>	
		</tr>
	</table>

	<?php if (!empty($validation)) { ?>
		<h1>Detailed validation report</h1>
		<table>
			<tr>
				<th>Row number</th>
				<th>Validation errors</th>
			</tr>
		<?php
			ksort($validation);
			foreach ($validation as $row => $error) {
				echo '<tr>';
					echo '<td rowspan="' . count($error) . '" style="width:25%">' . ($row + 2) . '</td>';
					echo '<td>' . reset($error) . '</td>';
				echo '</tr>';
				if (count($error) > 1) {
					unset($error[0]);
					foreach ($error as $errorMessage) {
						echo '<tr>';
							echo '<td>' . $errorMessage . '</td>';
						echo '</tr>';
					}
				}
			}
		?>
		</table>
	<?php } ?>

	<?php
		echo $this->Form->create('InstitutionModule', array('action' => 'save'));
		echo '<div class="submit bulkButtons">';
			echo $this->Form->button(__('Accept this import', true), array('name' => 'accept', 'id' => 'acceptBut'));
			echo $this->Form->button(__('Discard this import', true), array('name' => 'discard', 'id' => 'discardBut'));
		echo '</div>';
		echo $form->end();
	?>
</div>