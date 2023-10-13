<?php

class ReportHelper extends AppHelper {

	public $totalHeadings = array(
		'status' => array(
			'appA' => 'Appendix A',
			'appB' => 'Appendix B',
			'new' => 'New',
			'archived' => 'Archived',
			'submitted' => 'Submitted',
			'clTB' => 'To be checklisted',
			'clIn' => 'In checklisting',
			'clRet' => 'Checklisting return',
			'clCom' => 'Checklisting complete',
			'evalTB' => 'To be evaluated',
			'evalIn' => 'In evaluation',
			'eval' => 'Evaluated',
			'revTB' => 'To be reviewed',
			'revIn' => 'In review',
			'revRet' => 'Review return',
			'revCom' => 'Review complete',
			'revInst' => 'Institution review',
			'reSub' => 'Re-submitted after review'
		),
		'outcomes' => array(
			'accred' => 'Accredited',
			'recat' => 'Re-categorised',
			'notAccred' => 'Not accredited',
			'noOutcome' => 'No outcome',
		),
		'extras' => array(
			'outAccepted' => 'Accepted',
			'notified' => 'Notified',
			'total' => 'Total'
		)
	);

	public function totalsReportData($reportdata) {
		$return = array();
		$return['status'] = array();

		foreach ($reportdata as $data) {
			foreach ($data['Application'] as $field => $value) {
				if (isset($this->totalHeadings['status'][$field]) && $value > 0) {
					array_push($return['status'], $field);
				}
			}
		}
		$return['status'] = array_unique($return['status']);

		return $return;
	}
}