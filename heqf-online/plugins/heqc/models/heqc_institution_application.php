<?php
class HeqcInstitutionApplication extends HeqcAppModel {
	public $useTable = 'Institutions_application';
	public $primaryKey = 'application_id';
	public $name = 'HeqcInstitutionApplication';
	
	public $virtualFields = array(
		'NQF_ref' => 'HeqcInstitutionApplication.NQF_ref + 4',
		'site_name' => "CONCAT( HeqcInstitutionalProfileSite.site_name , ' (', HeqcInstitutionalProfileSite.institutional_profile_sites_id , ')' )",
		'full_time' => "REPLACE ((REPLACE (HeqcInstitutionApplication.full_time, ' years', '')), ' year', '')",
		'part_time' => "REPLACE ((REPLACE (HeqcInstitutionApplication.part_time, ' years', '')),' years', '')"
	);	
	
	public function getData($institution_id){
	
		$deliveryModes = array('1' => '1 Mixed mode', '2' => '2 Distance', '3' => '3 E-Learning', '4' => '4 Contact');
		$deliveryModesKeys = array_keys($deliveryModes);
   
		$data = array();
		
		$data = $this->find('all', array(
			'fields' => array(
				'HeqcInstitutionApplication.application_id',
				'HeqcInstitutionApplication.CHE_reference_code',
				'HeqcInstitutionApplication.program_name',
				'HeqcInstitutionApplication.saqa_reg_nr', 
				'HeqcInstitutionApplication.mode_delivery', 
				'HeqcInstitutionApplication.NQF_ref',
				'HeqcInstitutionApplication.num_credits',
				'HeqcInstitutionApplication.full_time',
				'HeqcInstitutionApplication.part_time',
				'HeqcInstitution.HEI_name',
				'HeqcInstitution.HEI_code',
				'HeqcInstitutionApplication.site_name'
				),
			
			'joins' => 	array(array('table' => 'HEInstitution',
								'alias' => 'HeqcInstitution',
								'type' => 'LEFT',
								'conditions' => array(
									'HeqcInstitution.HEI_id = HeqcInstitutionApplication.institution_id',
								)
							),
							array('table' => 'institutional_profile_sites',
								'alias' => 'HeqcInstitutionalProfileSite',
								'type' => 'LEFT',
								'conditions' => array(
									'HeqcInstitutionalProfileSite.institution_ref = HeqcInstitutionApplication.institution_id',
								)
							)
			),			
			
			'conditions' => array(
				'HeqcInstitutionApplication.institution_id' => $institution_id, 
			    'HeqcInstitutionApplication.AC_desision' => array('1', '2')
			)
		));
		
		$data = Set::combine($data, '{n}.HeqcInstitutionApplication.site_name', '{n}', '{n}.HeqcInstitutionApplication.application_id');
		
		if(!empty($data)){
			$return = array();
		
			foreach($data as $applications){
				$applicationReturn = reset($applications);
				
				$applicationReturn['Site'] = array_keys($applications);
		
				if(isset($deliveryModes[$applicationReturn['HeqcInstitutionApplication']['mode_delivery']])){
					$applicationReturn['HeqcInstitutionApplication']['mode_delivery'] = $deliveryModes[$applicationReturn['HeqcInstitutionApplication']['mode_delivery']];
				}				
				
				$return[] = $applicationReturn;
			}
		}

		if(empty($return)) {
			throw new Exception(__('No data was found with the given institution information.', true));
		}
		
		
		return $return;
	}
}