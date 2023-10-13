<?php

class AuditLog extends OctoLogAppModel {
	public function afterFind($results, $primary = true) {
		if($primary == true) {
			foreach($results as &$result) {
				$result['data'] = json_decode($result['data'], true);
			}
		}
		else {
			foreach($results as &$result) {
				$result['AuditLog']['data'] = json_decode($result['AuditLog']['data'], true);
			}
		}

		return $results;
	}
}
