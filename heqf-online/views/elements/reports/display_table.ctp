<?php
	$output = '';
	if(!empty($reportData)) {
		if(!empty($beforeTable)) {
			$output .= $beforeTable;
		}
		$output = '<table>';

		/**
		 * Header
		 */
			$output .= '<thead>';

			if(!empty($beforeHeadings)) {
				$output .= $beforeHeadings;
			}

			$headings = array();
			foreach($fields as $title => $field) {
				if(isset($this->Paginator)) {
					$headings[] = $this->Paginator->sort($title, $field);
				}
				else {
					$headings[] = $title;
				}
			}

			$output .= $this->Html->tableHeaders($headings);

			if(!empty($afterHeadings)) {
				$output .= $afterHeadings;
			}

			$output .= '</thead>';

		/**
		 * Body
		 */
			$tableCells = array();
			foreach($reportData as $reportItem) {
				$tableRow = array();
				foreach($fields as $field) {
					$tableRow[] = Sanitize::html(Set::extract($reportItem, $field));
				}
				$tableCells[] = $tableRow;
			}

			$output .= '<tbody>';
			if(!empty($beforeBody)) {
				$output .= $beforeBody;
			}
			$output .= $this->Html->tableCells($tableCells);
			if(!empty($afterBody)) {
				$output .= $afterBody;
			}
			$output .= '</tbody>';

		$output .= '</table>';

		if(!empty($afterTable)) {
			$output .= $afterTable;
		}
	}

	echo $output;

	if(isset($this->Paginator)) {
		echo $this->element('paging', array('plugin' => 'Octoplus'));
	}

