<?php

class AuditLogBehavior extends ModelBehavior {
	public $settings = array();
	private $defaults = array(
		'UserModel' => 'User'	,
		'order' => array('AuditLog.created' => 'ASC'),
		'history' => array(),
		'storeContain' => array()
	);
	private $currentValue = array();
	private $AuditLog = null;
	private $userId = null;
	
	public function setUser(&$Model, $userId) {
		$this->userId = $userId;
	}
	
	public function setup(&$Model, $settings) {
		if(!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = $this->defaults;
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
		
		$Model->bindModel(array(
			'hasMany' => array(
				'AuditLog' => array(
					'className' => 'OctoLog.AuditLog',
					'foreignKey' => 'foreign_key',
					'conditions' => array(
						'AuditLog.model' => $Model->name
					),
					'order' => $this->settings[$Model->alias]['order']
				)
			)
		), true);
		
		if($this->AuditLog === null) {
			$this->AuditLog = ClassRegistry::init('OctoLog.AuditLog');
			$this->AuditLog->bindModel(array(
				'belongsTo' => array(
					'CreatedBy' => array(
						'className' => $this->settings[$Model->alias]['UserModel'],
						'foreignKey' => 'created_by'
					)
				)
			), true);
		}
	}
	
	public function beforeSave(&$Model) {
		if(!empty($Model->data[$Model->alias][$Model->primaryKey])) {
			$this->currentValue[$Model->alias] = $Model->find('first', array(
				'conditions' => array(
					$Model->alias . '.' . $Model->primaryKey => $Model->data[$Model->alias][$Model->primaryKey]
				)
			));

			if(empty($this->settings[$Model->alias]['storeContain'])) {
				$this->currentValue[$Model->alias] = $this->currentValue[$Model->alias][$Model->alias];
			}
		}
		elseif(isset($this->currentValue[$Model->alias])) {
			unset($this->currentValue[$Model->alias]);
		}
	}

	public function generateDiff(&$Model, $currentValues, $changedValues) {
		$diff = array();

		$changedFields = array_diff_assoc($currentValues[$Model->alias], $changedValues[$Model->alias]);
		unset($changedFields['modified']);
		$changedFields = array_keys($changedFields);

		if(!empty($changedFields)) {
			foreach($changedFields as $changedField) {
				if(isset($changedValues[$Model->alias][$changedField]) && isset($currentValues[$Model->alias][$changedField])) {
					$diff[$changedField] = array(
						'before' => $currentValues[$Model->alias][$changedField],
						'after' => $changedValues[$Model->alias][$changedField]
					);
				}
			}
		}

		return $diff;
	}

	public function saveDiff(&$Model, $currentValues, $changedValues) {
		$diff = $this->generateDiff($Model, $currentValues, $changedValues);

		if(!empty($diff)) {
			$saveData['AuditLog'] = array(
				'model' => $Model->name,
				'foreign_key' => $changedValues[$Model->alias][$Model->primaryKey],
				'data' => json_encode($diff),
				'created_by' => $this->userId
			);

			$this->AuditLog->create();
			$this->AuditLog->save($saveData);
		}

		return $diff;
	}

	public function afterSave(&$Model, $created = false) {
		if($created === false && !empty($this->currentValue[$Model->alias])) {
			$updatedRecord = $Model->find('first', array(
				'conditions' => array(
					$Model->alias . '.' . $Model->primaryKey => $Model->data[$Model->alias][$Model->primaryKey]
				)
			));

			$this->saveDiff($Model, $this->currentValue, $updatedRecord);
		}
		
		unset($this->currentValue[$Model->alias]);
	}
	
	public function history(&$Model, $id) {
		$options = $this->settings[$Model->alias]['history'];
		
		$options['contain']['AuditLog'] = array('CreatedBy', 'order' => array('AuditLog.created' => 'ASC'));
		$options['conditions'][$Model->alias.'.'.$Model->primaryKey] = $id;
		
		$item = $Model->find('first', $options);
		
		if($item === false) {
			throw new OutOfBoundsException(__($this->settings[$Model->alias]['history']['exceptionMessage'], true));
		}
		
		
		$lastUpdate = $item[$Model->alias];
		$history = array();
		$item['AuditLog'][] = array(
			'data' => $lastUpdate
		);
		
		foreach($item['AuditLog'] as $key => $logItem) {
			if(isset($item['AuditLog'][$key+1])) {
				$nextItem = $item['AuditLog'][$key+1];
				$arrayDiff = Set::diff($logItem['data'], $nextItem['data']);
				
				$history[strtotime($logItem['created'])] = array(
					'CreatedBy' => $logItem['CreatedBy'],
					'changes' => array_keys($arrayDiff),
					'this' => $logItem['data'],
					'next' => $nextItem['data']
				);
			}
		}
		
		return array(
			'current' => $item,
			'history' => $history
		);
	}
}
