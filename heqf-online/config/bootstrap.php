<?php
Cache::config('validation', array(
	'engine' => 'NamespaceFile',
	'duration' => Configure::read('debug') > 0 ? 0 : '+1 day',
	'prefix' => 'validation.'
));

$statusEngine = 'File';
//If the server has APC we should use that for the upload status
if (function_exists('apc_fetch')) {
	$statusEngine = 'Apc';
}
Cache::config('uploadStatus', array(
	'engine' => $statusEngine,
	'duration' => '+1 hour',
	'prefix' => 'heqf_upload_'
));

if (Configure::read()) {
	//Cache::delete('private', 'validation');
}

App::import('Core', 'Security');
Security::setHash('sha256');

function writeStatus($status, $uniqueId) {
	$currentStatus = readStatus($uniqueId);

	$status = array_merge($currentStatus, $status);
	Cache::write($uniqueId, $status, 'uploadStatus');
}

function readStatus($uniqueId) {
	$status = Cache::read($uniqueId, 'uploadStatus');
	if (!is_array($status)) {
		$status = array();
	}
	return $status;
}

function clearStatus($uniqueId) {
	Cache::delete($uniqueId, 'uploadStatus');
}
