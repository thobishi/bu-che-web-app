<h1 style="color: #993;font-family:\'Gill Sans\',\'lucida grande\', helvetica, arial, sans-serif;font-size: 165%;">HEQSF-online validation report - <?php echo date('d F Y', time()); ?></h1>

<?php
	if ($user = Auth::get()) {
	?>
	<table>
		<tr>
			<td style="background-color:lightgrey;width:150px">
				Institution Code
			</td>
			<td>
				<?php echo $user['Institution']['hei_code']; ?>
			</td>		
		</tr>
		<tr>
			<td style="background-color:lightgrey;width:150px">
				Institution Name
			</td>
			<td>
				<?php echo $user['Institution']['hei_name']; ?>
			</td>			
		</tr>
		<tr>
			<td>
				
			</td>
			<td>
				
			</td>					
		</tr>
	</table>

	<?php
	}
?>
<br/>
<br/>
<table>
	<tr>
		<th style="border-color:#555;border-style:solid;border-width:1px;text-align:left;background-color:lightgrey;">
		</th>
		<th style="border-color:#555;border-style:solid;border-width:1px;text-align:left;background-color:lightgrey;">
			Section 1: Existing qualification
		</th>
		<th style="border-color:#555;border-style:solid;border-width:1px;text-align:left;background-color:lightgrey;">
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
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#D6FFDA;">
			Total passed validation
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#D6FFDA;">
			<?php echo $sheetInfo['correctRecords']['S1 Existing qualification info'];?>
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#D6FFDA;">
			<?php echo $sheetInfo['correctRecords']['S2 Amended qualification info'];?>
		</td>		
	</tr>
	<tr>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FFCC00;">
			Total failed but may be imported
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FFCC00;">
			<?php echo $sheetInfo['totalErrors']['S1 Existing qualification info'];?>
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FFCC00;">
			<?php echo $sheetInfo['totalErrors']['S2 Amended qualification info'];?>
		</td>		
	</tr>
	<tr>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FFCDBD;">
			Total core failed - not imported
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FFCDBD;">
			<?php echo $sheetInfo['totalCoreErrors']['S1 Existing qualification info'];?>
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FFCDBD;">
			<?php echo $sheetInfo['totalCoreErrors']['S2 Amended qualification info'];?>
		</td>		
	</tr>	
		<tr>
			<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#DFF2FF;">
				Duplicate errors - not imported
			</td>
			<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#DFF2FF;">
				<?php echo $sheetInfo['duplicateErrors']['S1 Existing qualification info'];?>
			</td>
			<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#DFF2FF;">
				<?php echo $sheetInfo['duplicateErrors']['S2 Amended qualification info'];?>
			</td>		
		</tr>	
	<tr>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#E8DED1;">
			Submitted errors - not imported
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#E8DED1;">
			<?php echo $sheetInfo['submittedErrors']['S1 Existing qualification info'];?>
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#E8DED1;">
			<?php echo $sheetInfo['submittedErrors']['S2 Amended qualification info'];?>
		</td>		
	</tr>	
		<tr>
			<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#C2DED1;">
				Category errors - not imported
			</td>
			<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#C2DED1;">
				<?php echo $sheetInfo['categoryErrors']['S1 Existing qualification info'];?>
			</td>
			<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#C2DED1;">
				-
			</td>		
		</tr>	
	<tr>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FCE4FF;">
			Total records where the corresponding qualification number was not found in Section 1
		</td>
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FCE4FF;">
		-
		</td>		
		<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:#FCE4FF;">
			<?php echo $sheetInfo['nonExistErrors']['S2 Amended qualification info'];?>
		</td>		
	</tr>	
</table>

<?php
	echo $this->Form->create('HeqfQualification', array('action' => 'saveData'));
	foreach ($finalData as $report) {
		unset($report['correctRecords']);
		unset($report['recordErrors']);
		unset($report['totalRecords']);
		unset($report['totalCoreErrors']);
		$currentRecordCount = 0;
		if (count($report['validationData']) > 0) {
		?>
			<br><br>
			<table>
		<?php
			foreach ($report['validationData'] as $sheet => $data) {
				$section = ($sheet == 'S1 Existing qualification info') ? 'section1Fields' : 'section2Fields';

				echo '<h3 style="color: #993;font-family:\'Gill Sans\',\'lucida grande\', helvetica, arial, sans-serif;font-size: 130%;">' . $sheet . '</h3><br>';
			?>
				<tr>
					<th style="border-color:#555;border-style:solid;border-width:1px;text-align:left;background-color:lightgrey;">
						Record No
					</th>
					<th style="border-color:#555;border-style:solid;border-width:1px;text-align:left;background-color:lightgrey;">
						Qualification reference
					</th>
					<th style="border-color:#555;border-style:solid;border-width:1px;text-align:left;background-color:lightgrey;">
						Field failed
					</th>			
					<th style="border-color:#555;border-style:solid;border-width:1px;text-align:left;background-color:lightgrey;">
						Validation message
					</th>			
				</tr>
				<?php
					$rowCount = 1;
					foreach ($data as $recordNum => $record) {
						if (isset($record['coreError']) && (count($record['coreError']) > 0)) {
							//coreErrors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['coreError']['s1_qualification_reference_no'] : $record['coreError']['qualification_reference_no'];
							foreach ($record['coreError']['coreErrorFields'] as $key => $fieldName) {
								$rowCount++;
								$rowColor = (($rowCount % 2) == 0) ? '#FFCDBD' : '#E5B8AA';
							?>
								<tr>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $recordNum + 1; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $qualRefNo; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $this->Heqf->{$section}[$fieldName]; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo 'Core error: Compulsory field'; ?>
									</td>									
								</tr>
							<?php
							}
						}

						if (isset($record['recordError']) && (count($record['recordError']) > 0) ) {
							//recordErrors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['recordError']['s1_qualification_reference_no'] : $record['recordError']['qualification_reference_no'];

							foreach ($record['recordError']['recordErrorFields'] as $fieldName => $message) {
								$rowCount++;
								$rowColor = (($rowCount % 2) == 0) ? '#FFCC00' : '#FFCC66';
							?>
								<tr>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $recordNum + 1; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $qualRefNo; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $this->Heqf->{$section}[$fieldName]; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $message; ?>
									</td>									
								</tr>
							<?php
							}
						}

						if (isset($record['nonExistantError']) && (count($record['nonExistantError']) > 0)) {
							//Non existant errors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['nonExistantError']['s1_qualification_reference_no'] : $record['nonExistantError']['qualification_reference_no'];
							foreach ($record['nonExistantError']['nonExistantErrorField'] as $fieldName => $message) {
								$rowCount++;
								$rowColor = (($rowCount % 2) == 0) ? '#FCE4FF' : '#E2CDE5';
							?>
								<tr>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $recordNum + 1; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $qualRefNo; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $this->Heqf->{$section}[$fieldName]; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $message; ?>
									</td>									
								</tr>
							<?php
							}
						}
						if (isset($record['duplicateError']) && (count($record['duplicateError']) > 0)) {
							//Duplicate errors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['duplicateError']['s1_qualification_reference_no'] : $record['duplicateError']['qualification_reference_no'];
							foreach ($record['duplicateError']['duplicateErrorField'] as $fieldName => $message) {
								$rowCount++;
								$rowColor = (($rowCount % 2) == 0) ? '#DFF2FF' : '#C8D9E5';
							?>
								<tr>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $recordNum + 1; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $qualRefNo; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $this->Heqf->{$section}[$fieldName]; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $message; ?>
									</td>									
								</tr>
							<?php
							}
						}
						if (isset($record['submittedError']) && (count($record['submittedError']) > 0)) {
							//Submitted errors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['submittedError']['s1_qualification_reference_no'] : $record['submittedError']['qualification_reference_no'];
							foreach ($record['submittedError']['submittedErrorField'] as $fieldName => $message) {
								$rowCount++;
								$rowColor = (($rowCount % 2) == 0) ? '#E8DED1' : '#F5EADC';
							?>
								<tr>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $recordNum + 1; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $qualRefNo; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $this->Heqf->{$section}[$fieldName];//$fieldName; ?>
									</td>
									<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
										<?php echo $message; ?>
									</td>									
								</tr>
							<?php
							}
						}
						if (isset($record['categoryError']) && (count($record['categoryError']) > 0)) {
							//Submitted errors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['categoryError']['s1_qualification_reference_no'] : $record['categoryError']['qualification_reference_no'];

							foreach ($record['categoryError']['categoryErrorField'] as $fieldName => $message) {
								$rowCount++;
								$rowColor = (($rowCount % 2) == 0) ? '#C2DED1' : '#CDEBDD';
							?>
									<tr>
										<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
											<?php echo $recordNum + 1; ?>
										</td>
										<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
											<?php echo $qualRefNo; ?>
										</td>
										<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
											<?php echo $this->Heqf->{$section}[$fieldName];//$fieldName; ?>
										</td>
										<td style="border-color:#fff;border-style:solid;border-width:1px;text-align:left;background-color:<?php echo $rowColor; ?>;">
											<?php echo $message; ?>
										</td>									
									</tr>
							<?php
							}
						}
					}
			}
		?>
			</table>
		<?php
		}
	}