<div align="center">
	<?php echo $this->Html->image($this->Html->url('/webroot/img/che_header.png', true)); ?>
</div>

<?php

	echo (!empty($variables['admin'])) ?  'Dear ' .$variables['admin']['User']['first_name'] . ' ' . $variables['admin']['User']['last_name'] : "Dear Institutional Administrator";
?>
<br><br><strong>COMPLETED HEQSF ALIGNMENT PROCESSING: CATEGORY B (DEFERRALS AND REPRESENTATIONS)</strong><br>


<p>The Higher Education Quality Committee (HEQC) of the Council on Higher Education (CHE) is responsible for the accreditation of the higher education learning programmes by virtue of the provisions of the Higher Education Act, 101 of 1997 (as amended) and the National Qualifications Framework Act, 67 of 2008.</p>

<p>A summary of applications that have been approved by the HEQC as HEQSF aligned for your institution are currently available on the HEQSF-online system. </p>

To access this list, please follow these instructions:
<ol>
	<li>Login to HEQSF-online system</li>
	<li>Under <strong>Reports</strong>, select <strong>Offerings per Institution</strong></li>
	<li>The Institution will be able to view the full list of currently approved HEQSF-aligned qualifications.</li>
</ol>
<p>The CHE will also be communicating the outcomes of all completed processes to the Department of Higher Education and Training (DHET) and the South African Qualifications Authority (SAQA) to allow these partner organisations to continue with their individual processes.</p>

<p>Should you have any queries in this regard, kindly contact the CHE on heqsfonline@che.ac.za.</p>
<p>Sincerely</p>
<div>
	<?php echo $this->Html->image($this->Html->url('/webroot/img/prof_naidoo_signature.png', true)); ?>
</div>
<p>Professor Kethamonie Naidoo<br>
Director: Accreditation</p>