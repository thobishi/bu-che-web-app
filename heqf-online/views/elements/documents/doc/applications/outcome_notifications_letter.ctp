<?php echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';?>
<DOC
	config_file="<?php echo WWW_ROOT;?>doc_config.inc"
	title="Outcome notification letter"
	subject="Outcome notification letter"
	author="CHE"
	manager="CHE"
	company="CHE"
	operator="CHE"
	category="Letter"
	comment=""
>

	<img width="120" src="<?php echo WWW_ROOT;?>img/documents/letter_header.png" wrap="around" align="center" />
	<br /><br />
	<img width="30" height="250" src="<?php echo WWW_ROOT;?>img/documents/side.png" wrap="around" align="left"  />

	<p before="5" after="5" align="center">
		<font size="20" face="arial">
			<br /><br /><br /><br />
			<b>
				CHE (Council On Higher Education)<br />
				Letter generated : <i><?php echo date('j F Y'); ?></i><br />
				Some more text
			</b>
		</font>
	</p>

	<page />
	
	<p align="left"><b><u><font size="18" face="arial">Letter text</font></u></b></p>
	<br />
	<p align="left">
		<font size="12" face="arial">
			The CHE letter text will come here.
			<br /><br />
			Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text.<br /><br />
			Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text.<br /><br />
			Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text. Some more text.
		</font>
	</p>
	
	<page />
	
	<p align="left"><b><u><font size="18" face="arial">Programmes</font></u></b></p>

	<br />

	<font size="12" face="arial">
	<?php
		foreach($docData as $programme){
	?>
			<table cellpadding="1">
				<tr>
					<td bgcolor="15"><b>Qualification title</b></td>
					<td><?php echo $programme['HeqfQualification']['qualification_title']; ?></td>
				</tr>
				<tr>
					<td bgcolor="15"><b>Qualification reference number</b></td>
					<td><?php echo $programme['HeqfQualification']['qualification_reference_no']; ?></td>
				</tr>
				<tr>
					<td bgcolor="15"><b>Submission date</b></td>
					<td><?php echo $programme['Application']['submission_date']; ?></td>
				</tr>
				<tr>
					<td bgcolor="15"><b>Meeting date</b></td>
					<td><?php echo $programme['HeqcMeeting']['date']; ?></td>
				</tr>
			</table>
			<br />
	<?
		}
	?>
	</font>
</DOC>