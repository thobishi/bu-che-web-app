<?php
class UserAuthBehavior extends ModelBehavior {
	public function alternativeAuth($Model, $type, $credentials = array()) {
		switch ($type) {
            case 'credentials':
				$currentUser = $Model->find('count', array('conditions' => array('User.email_address' => $credentials['email_address'])));

				if($currentUser == 0) {
					$HeqcUser = ClassRegistry::init('Heqc.HeqcUser');

					App::import('Sanitize');
					$cleanPassword = Sanitize::clean($credentials['password'], 'heqc');

					$user = $HeqcUser->find('first', array(
						'conditions' => array(
							'HeqcUser.email' => $credentials['email_address'],
							'HeqcUser.`password` = password(\''.$cleanPassword.'\')',
							'HeqcUser.active' => 1
						),
						'contain' => array(
							'UserGroup'
						)
					));

					if($user !== false) {
						$userGroups = Set::extract('/UserGroup/sec_group_ref', $user);

						if($user['HeqcUser']['institution_ref'] != 2) {
							if(in_array(4, $userGroups)) {
								$role = $Model->Role->findByInstAdmin(1);
							}
							else {
								$role = $Model->Role->findByDefault(1);
							}
						}
						else {
							if(in_array(3, $userGroups)) {
								$role = $Model->Role->findByCheAdmin(1);
							}
							else {
								$role = $Model->Role->findByCheDefault(1);
							}
						}

						$newUser = array(
							'User' => array(
								'first_name' => $user['HeqcUser']['name'],
								'last_name' => $user['HeqcUser']['surname'],
								'email_address' => $user['HeqcUser']['email'],
								'password' => Auth::hash($credentials['password']),
								'institution_id' => $user['HeqcUser']['institution_ref'],
								'heqc_institution_id' => $user['HeqcUser']['institution_ref'],
								'email_authenticated' => 1,
								'active' => 1,
								'ignoreRole' => 1
							),
							'Role' => array(
								'Role' => array(
									$role['Role']['id']
								)
							)
						);

						$Model->save($newUser);

						return $Model->find('first', array(
							'conditions' => array(
								'User.id' => $Model->id
							),
							'contain' => $this->authLoginContain($Model, array('Role'))
						));
					}

					return false;
				}
				break;
		}

		return false;
	}

	public function beforeValidate($Model) {
		if(!empty($Model->data)) {
			if(isset($Model->data['User']['institution_other']) && $Model->data['User']['institution_other']) {
				unset($Model->validate['heqc_institution_id']);
			}
			else {
				unset($Model->validate['institution_name']);
			}
		}
	}

	public function beforeSave($Model) {
		if(isset($Model->data['User']['institution_other']) && $Model->data['User']['institution_other']) {
			$LastHeiCode = ClassRegistry::init('Heqc.HeqcLastHeiCode');
			$instNumber = $LastHeiCode->find('first', array('conditions' => array('HeqcLastHeiCode.public_private' => 'PR')));

			$newInst = array(
				'HEI_name' => $Model->data['User']['institution_name'],
				'HEI_code' => 'PR'.$instNumber['HeqcLastHeiCode']['hei_code_num'],
				'hei_name' => $Model->data['User']['institution_name'],
				'hei_code' => 'PR'.$instNumber['HeqcLastHeiCode']['hei_code_num'],
				'priv_publ' => 1
			);

			if($Model->HeqcInstitution->save(array('HeqcInstitution' => $newInst))) {
				$newInst['id'] = $Model->HeqcInstitution->id;
				$Model->data['User']['heqc_institution_id'] = $Model->HeqcInstitution->id;
				if($Model->Institution->save(array('Institution' => $newInst))) {
					$Model->data['User']['institution_id'] = $Model->Institution->id;

					$LastHeiCode->updateAll(array('hei_code_num' => 'hei_code_num + 1'), array($LastHeiCode->primaryKey => $instNumber['HeqcLastHeiCode'][$LastHeiCode->primaryKey]));
				}
				else {
					$Model->HeqcInstitution->delete($Model->HeqcInstitution->id);

					return false;
				}
			}
			else {
				return false;
			}
		}

		if(!empty($Model->data['User']['heqc_institution_id']) && empty($Model->data['User']['id'])) {
			if(empty($Model->data['User']['ignoreRole'])) {
				$adminUser = $Model->find('first', array(
					'conditions' => array(
						'User.heqc_institution_id' => $Model->data['User']['heqc_institution_id'],
						'Role.inst_admin' => 1
					),
					'contain' => array(
						'Role'
					)
				));

				if($adminUser === false) {
					$roleId = $Model->Role->findByInstAdmin(1);

					$Model->data['User']['role_id'] = $roleId['Role']['id'];
				}
				else {
					throw new OutOfBoundsException(
						nl2br(sprintf(
							__("You already have an institutional administrator. Please ask your institutional administrator to add you as a user for your institution.\r\nYour institutional administrator is %s %s.", true),
							$adminUser['User']['first_name'],
							$adminUser['User']['last_name']
						))
					);

					return false;
				}
			}

			$heqcInstitution = $Model->HeqcInstitution->find('first', array('conditions' => array('HeqcInstitution.HEI_id' => $Model->data['User']['heqc_institution_id'])));
			$localInstitution = $Model->Institution->find('first', array(
				'conditions' => array(
					'or' => array(
						'Institution.id' => $Model->data['User']['heqc_institution_id'],
						'Institution.hei_code LIKE' => $heqcInstitution['HeqcInstitution']['HEI_code'],
						'Institution.hei_name LIKE' => $heqcInstitution['HeqcInstitution']['HEI_name']
					)
				)
			));

			if(empty($localInstitution)) {
				$localInstitution = array(
					'Institution' => array(
						'hei_name' => $heqcInstitution['HeqcInstitution']['HEI_name'],
						'hei_code' => $heqcInstitution['HeqcInstitution']['HEI_code'],
						'priv_publ' => $heqcInstitution['HeqcInstitution']['priv_publ']
					)
				);

				$Model->Institution->save($localInstitution);

				$Model->data['User']['institution_id'] = $Model->Institution->id;
			}
			else {
				$Model->data['User']['institution_id'] = $localInstitution['Institution']['id'];
			}
		}

		return true;
	}

	public function authLoginContain(&$Model, $contain = array()) {
		$contain[] = 'Institution';

		return $contain;
	}

	public function searchActivation(&$Model, $data, $field) {
		if ($data[$field['name']] == 0) {
			return array('User.active' => 0);
		} elseif ($data[$field['name']] == 1) {
			return array('User.active' => 1);
		}
	}

	public function searchUser(&$Model, $data = array()) {
		$search = array(
				'or' => array(
					'User.first_name LIKE' => '%' . $data['search'] . '%',
					'User.last_name LIKE' => '%' . $data['search'] . '%',
					'User.email_address LIKE' => '%' . $data['search'] . '%',
				)
			);

		return $search;
	}

	public function findByRoles(&$Model, $data = array()) {
		$Model->RolesUser->Behaviors->attach('Search.Searchable');
		$query = $Model->RolesUser->getQuery('all', array(
				'conditions' => array('RolesUser.role_id'  => $data['role_id']),
				'fields' => array('RolesUser.user_id')
		));
		return $query;
	}

	public function toggle_admin(&$Model, $userId, $params) {
		$defaultRole = $Model->Role->findByDefault(1);
		$adminRole = $Model->Role->findByInstAdmin(1);
		$user = $Model->read(array('institution_id'), $userId);
		
		/*
			if 
		pr($params);
		if(!empty($user)){
			$instID = $user['User']['institution_id'];
			$allUsers = $Model->find('all', array(
				'conditions' => array('User.institution_id' => $instID),
				'contain' => 'Role'
			));
		}
		if(!empty($allUsers)){
			foreach($allUsers as $foundUser){
				if($foundUser['Role']['inst_admin'] == 1){
					if($foundUser['User']['id'] != $userId){
						$return['AdminUser'] = array(
								'first_name' => $foundUser['User']['first_name'],
								'last_name' => $foundUser['User']['last_name'],
								'email_address' => $foundUser['User']['email_address']
						);
					}
				}
				if($foundUser['User']['id'] == $userId){
					$return['SelectedUser'] = array(
							'first_name' => $foundUser['User']['first_name'],
							'last_name' => $foundUser['User']['last_name'],
							'email_address' => $foundUser['User']['email_address']
					);					
				}
			}
			return $return;
		}
		return false;
		*/
		$Model->updateAll(array('User.role_id' => "'" . $defaultRole['Role']['id'] . "'"), array('User.institution_id' => $user['User']['institution_id']));
		$Model->id = $userId;
		$Model->saveField('role_id', $adminRole['Role']['id']);

		return true;
	}

	public function checkAdmin(&$Model, $data) {
		$adminRole = $Model->Role->findByInstAdmin(1);

		if($data['role_id'] == $adminRole['Role']['id'] && !empty($Model->data['User']['institution_id'])) {
			$adminUser = $Model->find('count', array(
				'conditions' => array(
					'User.id !=' => $Model->data['User']['id'],
					'User.institution_id' => $Model->data['User']['institution_id'],
					'User.role_id' => $adminRole['Role']['id']
				)
			));

			return $adminUser === 0;
		}

		return true;
	}
	
	public function logout(&$Model) {
		$Model->Session->delete('search');
	}

	public function listByRole(&$Model, $roleId) {
		$Model->virtualFields['name'] = 'CONCAT(User.last_name, ", ", User.first_name, " (", User.email_address, ")")';

		return $Model->find('list', array(
			'fields' => array(
				'User.name'
			),
			'conditions' => array(
				'RolesUser.role_id' => $roleId,
			),
			'joins' => array(
				array(
					'table' => 'roles_users',
					'alias' => 'RolesUser',
					'conditions' => array('RolesUser.user_id = User.id')
				)
			),
			'group' => array('User.id'),
			'order'=>array('User.last_name'=>'ASC','User.first_name'=>'ASC')
		));
	}

	public function searchRole(&$Model, $data, $field = array()) {
		$Model->RolesUser->Behaviors->attach('Containable', array('autoFields' => false));
		$Model->RolesUser->Behaviors->attach('Search.Searchable');
		$query = $Model->RolesUser->getQuery('all', array(
			'conditions' => array('RolesUser.role_id' => $data['role']),
			'fields' => array('RolesUser.user_id')
		));
		return $query;
	}
}