<?php
	$uniqueId = $this->Session->read('uniqueId');
	$sheetInfo = $this->Session->read('validation.sheetInfo');
	$browser = $this->Session->read('validation.browser');
	$finalData = $this->Session->read('validation.finalData');
	$onlineEdited = $this->Session->read('validation.online_edited');
?>

<div class="import-validation">
	<table class="validationSummaryTable">
		<tr>
			<th>
			</th>
			<th>
				Section 1: Existing qualification
			</th>
			<th>
				Section 2: HEQSF qualification
			</th>
		</tr>
		<tr>
			<td>
				Total records in file
			</td>
			<td>
				<?php echo $sheetInfo['totalRecords']['S1 Existing qualification info'];?>
			</td>		
			<td>
				<?php echo $sheetInfo['totalRecords']['S2 Amended qualification info'];?>
			</td>		
		</tr>
		<tr>
			<td  class="passedRecord">
				Total passed validation
			</td>
			<td  class="passedRecord">
				<?php echo $sheetInfo['correctRecords']['S1 Existing qualification info'];?>
			</td>
			<td  class="passedRecord">
				<?php echo $sheetInfo['correctRecords']['S2 Amended qualification info'];?>
			</td>		
		</tr>
		<tr>
			<td class="errorRecordEven">
				Total failed but may be imported
			</td>
			<td class="errorRecordEven">
				<?php echo $sheetInfo['totalErrors']['S1 Existing qualification info'];?>
			</td>
			<td class="errorRecordEven">
				<?php echo $sheetInfo['totalErrors']['S2 Amended qualification info'];?>
			</td>		
		</tr>
		<tr>
			<td class="coreRecordEven">
				Total core failed - not imported
			</td>
			<td class="coreRecordEven">
				<?php echo $sheetInfo['totalCoreErrors']['S1 Existing qualification info'];?>
			</td>
			<td class="coreRecordEven">
				<?php echo $sheetInfo['totalCoreErrors']['S2 Amended qualification info'];?>
			</td>		
		</tr>	
		<tr>
			<td class="duplicateRecordEven">
				Duplicate errors - not imported
			</td>
			<td class="duplicateRecordEven">
				<?php echo $sheetInfo['duplicateErrors']['S1 Existing qualification info'];?>
			</td>
			<td class="duplicateRecordEven">
				<?php echo $sheetInfo['duplicateErrors']['S2 Amended qualification info'];?>
			</td>		
		</tr>	
		<tr>
			<td class="submittedRecordEven">
				Submitted errors - not imported
			</td>
			<td class="submittedRecordEven">
				<?php echo $sheetInfo['submittedErrors']['S1 Existing qualification info'];?>
			</td>
			<td class="submittedRecordEven">
				<?php echo $sheetInfo['submittedErrors']['S2 Amended qualification info'];?>
			</td>		
		</tr>	
		<tr>
			<td class="categoryRecordEven">
				Category errors - not imported
			</td>
			<td class="categoryRecordEven">
				<?php echo $sheetInfo['categoryErrors']['S1 Existing qualification info'];?>
			</td>
			<td class="categoryRecordEven">
				-
			</td>		
		</tr>		
		<tr>
			<td class="missingRecordEven">
				Total records where the corresponding qualification number was not found in Section 1
			</td>
			<td class="missingRecordEven">
			-
			</td>		
			<td class="missingRecordEven">
				<?php echo $sheetInfo['nonExistErrors']['S2 Amended qualification info'];?>
			</td>		
		</tr>	
	</table>

	<?php
		$recordCount = $sheetInfo['correctRecords']['S1 Existing qualification info'] + $sheetInfo['correctRecords']['S2 Amended qualification info'] + $sheetInfo['totalErrors']['S1 Existing qualification info'] + $sheetInfo['totalErrors']['S2 Amended qualification info'] + $sheetInfo['totalCoreErrors']['S1 Existing qualification info'] + $sheetInfo['totalCoreErrors']['S2 Amended qualification info'] + $sheetInfo['nonExistErrors']['S2 Amended qualification info'] + $sheetInfo['duplicateErrors']['S1 Existing qualification info'] + $sheetInfo['duplicateErrors']['S2 Amended qualification info'] + $sheetInfo['submittedErrors']['S1 Existing qualification info'] + $sheetInfo['submittedErrors']['S2 Amended qualification info'] + $sheetInfo['categoryErrors']['S1 Existing qualification info'];

		$listEdited = '';
		$iterations = (isset($browser) && $browser == true) ? 25 : 5;
		echo $this->Form->create('HeqfQualification', array('action' => 'saveData'));
		$currentRecordCount = 0;
		$sheetCount = 0;

		writeStatus(array(
			'current_function' => 'finished',
			'percent' => 100
		), $uniqueId);

		echo $this->Form->hidden("HeqfQualification.link");
		echo '<div class="submit bulkButtons">';
			echo $this->Form->button(__('Accept', true), array('name' => 'accept', 'id' => 'acceptBut'));
			echo $this->Form->button(__('Discard', true), array('name' => 'discard', 'id' => 'discardBut'));
		echo '</div>';
		echo $form->end();
	?>

	<?php
		echo $this->Form->create('HeqfQualification', array('url' => array('action' => 'download_report', 'ext' => 'pdf')));
		// echo $this->Form->hidden('sheetInfo', array('value' => json_encode($sheetInfo)));
		// echo $this->Form->hidden('finalData', array('value' => json_encode($finalData)));
		echo $this->Form->submit(__('Download Report', true), array('name' => 'download', 'div' => true));
		echo $form->end();
	?>

	<?php
		foreach ($finalData as $report) {
			unset($report['correctRecords']);
			unset($report['recordErrors']);
			unset($report['totalRecords']);
			unset($report['totalCoreErrors']);
			unset($report['duplicateErrors']);
			unset($report['submittedErrors']);
			if (count($report['validationData']) > 0) {
				// $number = 0;
				// $count = count($report['validationData']['S1 Existing qualification info']) + count($report['validationData']['S2 Amended qualification info']);
				foreach ($report['validationData'] as $sheet => $data) {
					foreach ($data as $recordNum => $record) {
						// $number++;
						// writeStatus(array(
						// 	'percent' => floor(($number / $count) * 100)
						// ), $uniqueId);
						if (isset($record['correctRecord']) && (count($record['correctRecord']) > 0) ) {
							if (!empty($onlineEdited) && isset($record['correctRecord']['s1_qualification_reference_no']) && in_array($record['correctRecord']['s1_qualification_reference_no'], $onlineEdited)) {
								$listEdited[$sheet][$recordNum + 1] = $record['correctRecord']['s1_qualification_reference_no'];
							}
						}

						if (isset($record['recordError']) && (count($record['recordError']) > 0)) {
							//recordErrors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['recordError']['s1_qualification_reference_no'] : $record['recordError']['qualification_reference_no'];
							if (!empty($onlineEdited) && in_array($qualRefNo, $onlineEdited)) {
								$listEdited[$sheet][$recordNum + 1] = $qualRefNo;
							}
						}

						if (isset($record['duplicateError']) && (count($record['duplicateError']) > 0)) {
							//Duplicate errors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['duplicateError']['s1_qualification_reference_no'] : $record['duplicateError']['qualification_reference_no'];
							if (!empty($onlineEdited) && in_array($qualRefNo, $onlineEdited)) {
								$listEdited[$sheet][$recordNum + 1] = $qualRefNo;
							}
						}
					}
				}
			}
		}

		if (!empty($listEdited)) {
			echo '<div id="editOnline" class="ui-helper-hidden">';
			$text = '<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>The following records have already been imported and edited on-line. Proceeding will overwrite the records.</p><br><br>';
			$text .= '<div><table style="width:450px;margin:0px auto;"><tr><th class="heading">Section</th><th class="heading">Record No</th><th class="heading">Qualification reference </th></tr>';
			$count = 1;
			foreach ($listEdited as $sheet => $values) {
				foreach ($values as $key => $value) {
					$class = (($count % 2) == 0) ? 'alertRecordEven' : 'alertRecordOdd';
					$text .= '<tr><td class="' . $class . '">' . $sheet . '</td><td class="' . $class . '">' . $key . '</td><td class="' . $class . '">' . $value . '</td></tr>';
					$count++;
				}
			}
			$text .= '</table></div>';
			echo $text;
			echo '</div>';
		}
	?>
</div>