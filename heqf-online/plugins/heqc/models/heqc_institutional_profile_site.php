<?php

class HeqcInstitutionalProfileSite extends HeqcAppModel {
	public $useTable = 'institutional_profile_sites';
	public $name = 'HeqcInstitutionalProfileSite';

	public aa$belongsTo = array(
		'HeqcInstitutionApplication'
	);		
	
}