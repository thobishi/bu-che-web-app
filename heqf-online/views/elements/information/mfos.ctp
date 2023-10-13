<div class="flash-messages">
	<div class="ui-state-good ui-corner-all">
		<strong>Current Major field of study</strong>:<br />
		<?php
			$majors = $this->Heqf->reportMultiple('; ', ',', $this->data['HeqfQualification'][$field], $hemis_qualifiers);
			echo (!empty($majors)) ? $majors : 'NONE';
		?>
		<hr />
		<ul>
			<li>
				Steps to select a <strong>Major field of study</strong>:
			</li>
			<li>
				<ul>
					<ol>Click on the <strong>Major field of study</strong> input field above</ol>
					<ol>Start typing either the code or text for the particular <strong>Major field of study</strong></ol>
					<ol>Click on the desired <strong>Major field of study</strong> from the drop down list</ol>
				</ul>
			</li>
			<li>
				To add another <strong>Major field of study</strong>, repeat the steps above
			</li>
			<li>
				To remove a <strong>Major field of study</strong>, click on the (x) button located on the top-left hand corner of the desired <strong>Major field of study</strong>
			</li>
	</div>
</div>