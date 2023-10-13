<?php

class AuditLogHelper extends AppHelper {
	public $helpers = array('Time', 'Html');

	public function history($options = array()) {
		$defaults = array(
			'history' => array(),
			'current' => array(),
			'fields' => array(),
			'createdName' => 'username',
			'mainAlias' => ''
		);

		$options = array_merge($defaults, $options);
		extract($options);

		$history = array_reverse($history, true);
		$output = '<ul>';

		foreach($history as $historyDate => $historyItem) {
			if(count($historyItem['changes']) > 1 || end($historyItem['changes']) !== 'modified') {
				$output .= '<li>';
				$output .= '<h4>Updated by ' . $historyItem['CreatedBy'][$createdName] . ' <span title="' . $this->Time->nice($historyDate) . '">' . $this->Time->relativeTime($historyDate) . '</span></h4>';
				$output .= '<ul>';
				foreach($historyItem['changes'] as $changedField) {
					$useString = '';
					$string = array(
						'added' => '<strong>%1$s</strong> set to <em>%3$s</em>',
						'removed' => '<strong>%1$s</strong> cleared. Previous value was <em>%2$s</em>',
						'changed' => '<strong>%1$s</strong> changed from <em>%2$s</em> to <em>%3$s</em>',
					);
					
					if(isset($fields[$changedField])) {
						if(!isset($fields[$changedField]['type']) && empty($fields[$changedField]['values'])) {
							$fields[$changedField]['type'] = 'text';
						}
						elseif(!isset($fields[$changedField]['type']) && !empty($fields[$changedField]['values'])) {
							$fields[$changedField]['type'] = 'select';
							if(empty($fields[$changedField]['default'])) {
								$fields[$changedField]['default'] = reset($fields[$changedField]['values']);
							}
						}

						switch ($fields[$changedField]['type']) {
							case 'file':
								$historyItem['next'][$changedField] = $this->Html->link($historyItem['next'][$changedField]['filename'], array(
									'controller' => 'files',
									'action' => 'download',
									'source' => $historyItem['next'][$changedField]['source'],
									'filename' =>  $historyItem['next'][$changedField]['filename'],
								));

								if(!empty($historyItem['this'][$changedField])) {
									$historyItem['this'][$changedField] = $this->Html->link($historyItem['this'][$changedField]['filename'], array(
										'controller' => 'files',
										'action' => 'download',
										'source' => $historyItem['this'][$changedField]['source'],
										'filename' =>  $historyItem['this'][$changedField]['filename'],
									));
									$string['changed'] = '<strong>%1$s</strong> (%2$s) replaced with %3$s.';
								}
								else {
									$string['added'] = '<strong>%1$s</strong> uploaded as %3$s.';
								}

								$string['removed'] = '<strong>%1$s</strong> removed. Previous file was %2$s.';
								break;
							case 'date':
								if(!empty($historyItem['next'][$changedField])) {
									$historyItem['next'][$changedField] = $this->Time->format('d F Y', $historyItem['next'][$changedField]);
								}

								if(!empty($historyItem['this'][$changedField])) {
									$historyItem['this'][$changedField] = $this->Time->format('d F Y', $historyItem['this'][$changedField]);
								}
								break;
							case 'select':
								if(!empty($historyItem['next'][$changedField])) {
									$historyItem['next'][$changedField] = $fields[$changedField]['values'][$historyItem['next'][$changedField]];
								}
								else {
									$historyItem['next'][$changedField] = $fields[$changedField]['default'];
								}

								if(!empty($historyItem['this'][$changedField])) {
									$historyItem['this'][$changedField] = $fields[$changedField]['values'][$historyItem['this'][$changedField]];
								}
								else {
									$historyItem['this'][$changedField] = $fields[$changedField]['default'];
								}
								break;
						}

						if(empty($historyItem['this'][$changedField]) && !empty($historyItem['next'][$changedField])) {
							$useString = 'added';
							$historyItem['this'][$changedField] = '';
						}
						elseif(empty($historyItem['next'][$changedField]) && !empty($historyItem['this'][$changedField])) {
							$useString = 'removed';
							$historyItem['next'][$changedField] = '';
						}
						elseif(!empty($historyItem['this'][$changedField]) && !empty($historyItem['next'][$changedField]) && $historyItem['next'][$changedField] !== $historyItem['this'][$changedField]) {
							$useString = 'changed';
						}

						if(!empty($useString)) {
							$output .= '<li>';
							$output .= sprintf($string[$useString], $fields[$changedField]['label'], $historyItem['this'][$changedField], $historyItem['next'][$changedField]);
							$output .= '</li>';
						}
					}
				}
				$output .= '</ul>';
				$output .= '</li>';
			}
		}

		$output .= '<li>';
		$output .= '<h4>Created by '.$current['Created']['loginName'].' <span title="'.$this->Time->nice($current[$mainAlias]['created']).'">'.$this->Time->relativeTime($current[$mainAlias]['created']).'</span></h4>';
		$output .= '</li>';

		$output .= '</ul>';

		return $output;
	}
}