<div align="center">
	<?php echo $this->Html->image($this->Html->url('/webroot/img/che_header.png', true)); ?>
</div>

<?php

	echo (!empty($variables['admin'])) ?  'Dear ' .$variables['admin']['User']['first_name'] . ' ' . $variables['admin']['User']['last_name'] : "Dear Institutional Administrator";
?>
<br><br><strong>COMPLETED HEQSF ALIGNMENT PROCESSING</strong><br>


<p>The Higher Education Quality Committee (HEQC) of the Council on Higher Education (CHE) is responsible for the accreditation of the higher education learning programmes by virtue of the provisions of the Higher Education Act, 101 of 1997 (as amended) and the National Qualifications Framework Act, 67 of 2008.</p>

<p>A summary of applications that have been deemed accredited and HEQSF aligned for your institution are currently available on the HEQSF-online system. </p>

To access this list, please follow these instructions:
<ol>
	<li>Login to HEQSF-online system</li>
	<li>Under <strong>Reports</strong>, select <strong>Offerings per Institution</strong></li>
	<li>The Institution will be able to view the full list of currently approved HEQSF-aligned qualifications.</li>
</ol>
<p>The CHE will also be communicating the outcomes of all completed processes to the Department of Higher Education and Training (DHET) and the South African Qualifications Authority (SAQA) to allow these partner organisations to continue with their individual processes.</p>


<?php

	/*if(!empty($variables['content'])){*/
?>
<!--<p>Below are the qualifications assigned to specific HEQC meeting dates, along with their outcomes:</p>
		<table id = "email_outcomeTable">
			<thead>
				<tr>
					<th>HEQC meeting</th>
					<th>Outcome</th>
					<th>Qualifications</th>
				<tr>
			</thead>
			<tbody>-->
<?php		
		/*foreach($variables['content'] as $meeting => $outcomeInfo){
			echo '<tr>';
				echo '<td>';
				 echo $meeting ;
				echo "</td>";
			echo '<td>';	
			foreach($outcomeInfo as $outcome => $qualifications){
				echo $outcome;
			}
			echo '</td>';
			echo '<td>';
				echo '<ul>';
				foreach($outcomeInfo as $outcome => $qualifications){
					foreach($qualifications as $qualification){
						echo '<li>' . $qualification . '</li>';
					}
				}
				echo '</ul>';
			echo "</td>";			
			
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}*/
?>

<p>Should you have any queries in this regard, kindly contact the CHE on heqsfonline@che.ac.za.</p>
<p>Sincerely</p>
<div>
	<?php echo $this->Html->image($this->Html->url('/webroot/img/prof_naidoo_signature.png', true)); ?>
</div>
<p>Professor Kethamonie Naidoo<br>
Director: Accreditation</p>