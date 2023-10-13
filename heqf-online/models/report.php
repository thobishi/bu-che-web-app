<?php
class Report extends AppModel {

	public $name = 'Report';

/**
 * [findReport description]
 * @param  [type] $reportSlug [description]
 * @return [type]             [description]
 * @throws Exception If the report does not exist
 */
	public function findReport($reportSlug) {
		$report = $this->findBySlug($reportSlug);

		if (!$report) {
			throw new Exception(__('The report you requested does not exist.', true));
		}

		/*if(!Permissions::hasPermission('reports.' . $report['Report']['permission'])) {
			throw new Exception(__('You do not have the required permissions to view that report.', true));
		}*/

		return $report['Report'];
	}
}