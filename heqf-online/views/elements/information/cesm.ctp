<div class="flash-messages">
	<div class="ui-state-good ui-corner-all">
		<strong>Current CESM:</strong><br />
		<?php
			$cesms = $this->Heqf->reportMultiple($this->data['HeqfQualification'][$field], $cesm_codes);
			echo (!empty($cesms)) ? $cesms : 'NONE';
		?>
		<hr />
		<ul>
			<li>
				Steps to select a <strong>CESM</strong>:
			</li>
			<li>
				<ul>
					<ol>Click on the <strong>CESM</strong> input field above</ol>
					<ol>Start typing either the code or text for the particular <strong>CESM</strong></ol>
					<ol>Click on the desired <strong>CESM</strong> from the drop down list</ol>
				</ul>
			</li>
			<li>
				To add another <strong>CESM</strong>, repeat the steps above
			</li>
			<li>
				To remove a <strong>CESM</strong>, click on the (x) button located on the top-left hand corner of the desired <strong>CESM</strong>
			</li>
	</div>
</div>