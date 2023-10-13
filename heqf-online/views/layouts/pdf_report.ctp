<table class="validationSummaryTable">
	<tr>
		<th>
		</th>
		<th>
			Section 1: Existing qualification
		</th>
		<th>
			Section 2: HEQF qualification
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
		<td>
			Total passed validation
		</td>
		<td>
			<?php echo  $sheetInfo['correctRecords']['S1 Existing qualification info'];?>
		</td>
		<td>
			<?php echo  $sheetInfo['correctRecords']['S2 Amended qualification info'];?>
		</td>		
	</tr>
	<tr>
		<td>
			Total failed but may be imported
		</td>
		<td>
			<?php echo $sheetInfo['totalErrors']['S1 Existing qualification info'];?>
		</td>
		<td>
			<?php echo $sheetInfo['totalErrors']['S2 Amended qualification info'];?>
		</td>		
	</tr>
	<tr>
		<td>
			Total core failed - not imported
		</td>
		<td>
			<?php echo $sheetInfo['totalCoreErrors']['S1 Existing qualification info'];?>
		</td>
		<td>
			<?php echo $sheetInfo['totalCoreErrors']['S2 Amended qualification info'];?>
		</td>		
	</tr>	
	<tr>
		<td>
			Total records where the corresponding qualification number was not found in Section 1
		</td>
		<td>
		-
		</td>		
		<td>
			<?php echo $sheetInfo['nonExistErrors']['S2 Amended qualification info'];?>
		</td>		
	</tr>	
</table>

<?php
	$record_count = $sheetInfo['totalErrors']['S1 Existing qualification info'] + $sheetInfo['totalErrors']['S2 Amended qualification info'] + $sheetInfo['totalCoreErrors']['S1 Existing qualification info'] + $sheetInfo['totalCoreErrors']['S2 Amended qualification info'] + $sheetInfo['nonExistErrors']['S2 Amended qualification info'];
	echo $this->Form->create('HeqfQualification', array('action' => 'saveData'));
	foreach($finalData as $report){
		unset($report['correctRecords']);
		unset($report['recordErrors']);
		unset($report['totalRecords']);
		unset($report['totalCoreErrors']);
		$currentRecordCount = 0;
		if(count($report['validationData']) > 0){
			
?>
			<table>
<?php
				foreach($report['validationData'] as $sheet => $data){
					echo '<h3>'.$sheet.'</h3>';
?>
					<tr>
						<th class="heading">
							Record No
						</th>
						<th class="heading">
							Qualification reference
						</th>
						<th class="heading">
							Field failed
						</th>			
						<th class="heading">
							Validation message
						</th>			
					</tr>
<?php
					foreach($data as $recordNum => $record){
						
						if(isset($record['coreError']) && (count($record['coreError']) > 0) ){
							//coreErrors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['coreError']['s1_qualification_reference_no'] : $record['coreError']['qualification_reference_no'];
							foreach($record['coreError']['coreErrorFields'] as $key => $fieldName){
?>
								<tr>
									<td>
										<?php echo $recordNum + 1; ?>
									</td>
									<td>
										<?php echo $qualRefNo; ?>
									</td>
									<td>
										<?php echo $fieldName; ?>
									</td>
									<td>
										<?php echo 'Core error: Compulsory field'; ?>
									</td>									
								</tr>
<?php								
							}
						}
						if(isset($record['recordError']) && (count($record['recordError']) > 0) ){
							//recordErrors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['recordError']['s1_qualification_reference_no'] : $record['recordError']['qualification_reference_no'];
							
							foreach($record['recordError']['recordErrorFields'] as $fieldName => $message){
?>
								<tr>
									<td>
										<?php echo $recordNum + 1; ?>
									</td>
									<td>
										<?php echo $qualRefNo; ?>
									</td>
									<td>
										<?php echo $fieldName; ?>
									</td>
									<td>
										<?php echo $message; ?>
									</td>									
								</tr>
<?php								
							}
						}
						if(isset($record['nonExistantError']) && (count($record['nonExistantError']) > 0) ){
							//Non existant errors
							$qualRefNo = ($sheet == 'S1 Existing qualification info') ? $record['nonExistantError']['s1_qualification_reference_no'] : $record['nonExistantError']['qualification_reference_no'];
							foreach($record['nonExistantError']['nonExistantErrorField'] as $fieldName => $message){
?>
								<tr>
									<td>
										<?php echo $recordNum + 1; ?>
									</td>
									<td>
										<?php echo $qualRefNo; ?>
									</td>
									<td>
										<?php echo $fieldName; ?>
									</td>
									<td>
										<?php echo $message; ?>
									</td>									
								</tr>
<?php								
							}
						}						
						
						$currentRecordCount++;
					}
				}
?>				
			</table>
<?php
			
		}

	}

?>