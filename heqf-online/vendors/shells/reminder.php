<?php
App::import('Component', 'OctoUsers.Auth');
class ReminderShell extends Shell {

     var $tasks = array('Email');
     var $uses = array('Evaluation', 'Application', 'Proceeding');

     public $emailData = array(
          'to' => null,
          'subject' => null,
          'from' => 'heqsf@octoplus.co.za',
          'bcc' => null,
          'sendAs' => 'text',
          'template' => 'reminder'
     );

     public $reminders = array(
          'model' => array(
               'Proceeding' => array(
                    'review_reminder1_period',
                    'review_reminder2_period',
                    'review_overdue1_period',
                    'review_overdue2_period'
               ),
               'Evaluation' => array(
                    'evaluation_reminder1_period',
                    'evaluation_reminder2_period',
                    'evaluation_overdue1_period',
                    'evaluation_overdue2_period'
               ),
               'Application' => array(
                    'review_reminder1_period',
                    'review_reminder2_period',
                    'review_overdue1_period',
                    'review_overdue2_period'
               )
          )
     );

     public $reminderFields = array(
          'evaluation_reminder1_period' => array('Evaluation' => 'evaluation_reminder1_sent_date'),
          'evaluation_reminder2_period' => array('Evaluation' => 'evaluation_reminder2_sent_date'),
          'evaluation_overdue1_period' => array('Evaluation' => 'evaluation_reminder3_sent_date'),
          'evaluation_overdue2_period' => array('Evaluation' => 'evaluation_reminder4_sent_date'),
          'review_reminder1_period' => array('Application' => 'review_reminder1_sent_date', 'Proceeding' => 'proc_reminder1_sent_date'),
          'review_reminder2_period' => array('Application' => 'review_reminder2_sent_date', 'Proceeding' => 'proc_reminder2_sent_date'),
          'review_overdue1_period' => array('Application' => 'review_reminder3_sent_date', 'Proceeding' => 'proc_reminder3_sent_date'),
          'review_overdue2_period' => array('Application' => 'review_reminder4_sent_date', 'Proceeding' => 'proc_reminder4_sent_date')  
     );

     function main() {
          foreach ($this->reminders['model'] as $model => $reminderTypes) {
               foreach ($reminderTypes as $reminderType) {
                    $this->sendReminder($model, $reminderType);
               }
          }
     }

     function sendReminder($model, $reminderType) {
          $this->emailData = $this->setEmailDefault($model);
         
          $reminderPeriod = $this->getReminderPeriod($reminderType);
          $assignedArr = $this->setParams($model, $reminderType);
         if(!empty($assignedArr)) {
               foreach ($assignedArr as $data) {
                    $duedateField = $this->getDueDateField($model);
                    $dueDateValue = $data[$model][$duedateField];             
                    $sendReminder = $this->checkReminderDue($dueDateValue, $reminderPeriod);
                    $to = $this->setEmailTo($model, $data);
                    $bcc =  $this->getEmailBcc();
                    $dataArr = $this->getEmailData($model, $data);
                    $dataArr['dueDate'] = $dueDateValue;
                    if ($sendReminder) {
                         $this->emailData['to'] = $to;
                         $this->emailData['bcc'] = $bcc;
                         $this->Email->set('data', $dataArr);
                         if ($this->Email->send($this->emailData)) {
                              $this->updateData($model, $reminderType, $data);
                         }
                    }
               }
          }
     }

     function updateData($model, $reminderType, $data) {
          $updateField = $this->reminderFields[$reminderType][$model];
          $dataUpdate = array(
               $updateField => 'NOW()'
          );
          $updateConditions = array(
               $model . '.id' => $data[$model]['id']
          );

          $this->{$model}->updateAll($dataUpdate, $updateConditions);
     }

     function getEmailData($model, $data) {
          $dataArr = array();
          switch ($model) {
               case 'Evaluation':
                    $dataArr['userName'] = $data['EvalUser']['first_name'] . ' ' . $data['EvalUser']['last_name'];
                    $dataArr['institution'] = $data['Application']['Institution']['hei_name'] . '( ' . $data['Application']['Institution']['hei_code'] . ' )';
                    $dataArr['reference'] = $data['Application']['HeqfQualification']['s1_qualification_reference_no'];
                    $dataArr['progName'] = $data['Application']['HeqfQualification']['qualification_title'];
                    $dataArr['process'] = 'Evaluation';
                    break;
                case 'Proceeding':
                    $dataArr['userName'] = $data['ProcUser']['first_name'] . ' ' . $data['ProcUser']['last_name'];
                    $dataArr['institution'] = $data['Application']['Institution']['hei_name'] . '( ' . $data['Application']['Institution']['hei_code'] . ' )';
                    $dataArr['reference'] = $data['Application']['HeqfQualification']['s1_qualification_reference_no'];
                    $dataArr['progName'] = $data['Application']['HeqfQualification']['qualification_title'];
                    $dataArr['process'] = 'Proceeding';
                    break;
               case 'Application':
                    $dataArr['userName'] = $data['User']['first_name'] . ' ' . $data['User']['last_name'];
                    $dataArr['institution'] = $data['Institution']['hei_name'] . '( ' . $data['Institution']['hei_code'] . ' )';
                    $dataArr['reference'] = $data['HeqfQualification']['s1_qualification_reference_no'];
                    $dataArr['progName'] = $data['HeqfQualification']['qualification_title'];
                    $dataArr['process'] = 'Review';
                    break;
          }

          return $dataArr;
     }

     function setEmailTo($model, $data) {
          switch ($model) {
               case 'Evaluation':
                    $address = $data['EvalUser']['email_address'];
                    break;
               case 'Proceeding':
                    $address = $data['ProcUser']['email_address'];
                    break;
               case 'Application':
                    $address = $data['User']['email_address'];
                    break;
          }
          $to = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $address : Configure::read('Email.debug_address');

          return $to;
     }

     function getDueDateField($model) {
          $field = '';
          switch ($model) {
               case 'Evaluation':
                    $field = 'evaluation_due_date';
                    break;
               case 'Proceeding':
                    $field = 'proc_due_date';
                    break;
               case 'Application':
                    $field = 'review_due_date';
                    break;
          }

          return $field;
     }

     function setEmailDefault ($model) {
          switch ($model) {
               case 'Evaluation':
                    $this->emailData['subject'] = 'HEQSF Evaluation Reminder';
                    break;
               
               case 'Application':
               case 'Proceeding':
                    $this->emailData['subject'] = 'HEQSF Review Reminder';
                    break;
          }

          return $this->emailData;
     }

     function setParams($model, $reminderType) {
          $conditions = array();
          $contain = array();

          if($model == 'Evaluation') {
               $contain = array(
                    'Application' => array(
                         'HeqfQualification',
                         'Institution'
                    ),
                    'EvalUser',
               );
               switch ($reminderType) {
                    case 'evaluation_reminder1_period':
                         $conditions[] = array(
                              'Evaluation.evaluation_due_date !=' => '1970-01-01',
                              'Evaluation.evaluation_reminder1_sent_date' => '1970-01-01',
                              'Evaluation.eval_status_id' => 'New',
                              'Evaluation.eval_inactive' => '0'
                         );
                    break;
                    case 'evaluation_reminder2_period':
                         $conditions[] = array(
                              'Evaluation.evaluation_due_date !=' => '1970-01-01',
                              'Evaluation.evaluation_reminder2_sent_date' => '1970-01-01',
                              'Evaluation.eval_status_id' => 'New',
                              'Evaluation.eval_inactive' => '0'
                         );
                    break;
                    case 'evaluation_overdue1_period':
                         $conditions[] = array(
                              'Evaluation.evaluation_due_date !=' => '1970-01-01',
                              'Evaluation.evaluation_reminder3_sent_date' => '1970-01-01',
                              'Evaluation.eval_status_id' => 'New',
                              'Evaluation.eval_inactive' => '0'
                         );
                    break;
                    case 'evaluation_overdue2_period':
                         $conditions[] = array(
                              'Evaluation.evaluation_due_date !=' => '1970-01-01',
                              'Evaluation.evaluation_reminder4_sent_date' => '1970-01-01',
                              'Evaluation.eval_status_id' => 'New',
                              'Evaluation.eval_inactive' => '0'
                         );
                    break;
               }
          }

          if($model == 'Proceeding') {
               $contain = array(
                    'Application' => array(
                         'HeqfQualification',
                         'Institution'
                    ),
                    'ProcUser',
               );
               switch ($reminderType) {
                    case 'review_reminder1_period':
                         $conditions[] = array(
                              'Proceeding.proc_due_date !=' => '1970-01-01',
                              'Proceeding.proc_reminder1_sent_date' => '1970-01-01',
                              'Proceeding.proc_status_id' => 'ReviewerNew',
                              'Proceeding.proc_inactive' => '0'
                         );
                    break;
                    case 'review_reminder2_period':
                         $conditions[] = array(
                              'Proceeding.proc_due_date !=' => '1970-01-01',
                              'Proceeding.proc_reminder2_sent_date' => '1970-01-01',
                              'Proceeding.proc_status_id' => 'ReviewerNew',
                              'Proceeding.proc_inactive' => '0'
                         );
                    break;
                    case 'review_overdue1_period':
                         $conditions[] = array(
                              'Proceeding.proc_due_date !=' => '1970-01-01',
                              'Proceeding.proc_reminder3_sent_date' => '1970-01-01',
                              'Proceeding.proc_status_id' => 'ReviewerNew',
                              'Proceeding.proc_inactive' => '0'
                         );
                    break;
                    case 'review_overdue2_period':
                         $conditions[] = array(
                              'Proceeding.proc_due_date !=' => '1970-01-01',
                              'Proceeding.proc_reminder4_sent_date' => '1970-01-01',
                              'Proceeding.proc_status_id' => 'ReviewerNew',
                              'Proceeding.proc_inactive' => '0'
                         );
                    break;
               }
          }

          if($model == 'Application') {
               $contain = array(
                    'HeqfQualification',
                    'Institution',
                    'User'
               );

               switch ($reminderType) {
                    case 'review_reminder1_period':
                         $conditions[] = array(
                              'Application.review_due_date !=' => '1970-01-01',
                              'Application.review_reminder1_sent_date' => '1970-01-01',
                              'Application.review_status_id' => 'New'
                         );
                    break;
                    case 'review_reminder2_period':
                         $conditions[] = array(
                              'Application.review_due_date !=' => '1970-01-01',
                              'Application.review_reminder2_sent_date' => '1970-01-01',
                              'Application.review_status_id' => 'New'
                         );
                    break;
                    case 'review_overdue1_period':
                         $conditions[] = array(
                              'Application.review_due_date !=' => '1970-01-01',
                              'Application.review_reminder3_sent_date' => '1970-01-01',
                              'Application.review_status_id' => 'New'
                         );
                    break;
                    case 'review_overdue2_period':
                         $conditions[] = array(
                              'Application.review_due_date !=' => '1970-01-01',
                              'Application.review_reminder4_sent_date' => '1970-01-01',
                              'Application.review_status_id' => 'New'
                         );
                    break;
               }
          }

          $assignedArr = $this->{$model}->find('all', array(
               'conditions' => $conditions,
               'contain' => $contain
          ));
          
          return $assignedArr;

     }

     function getReminderPeriod($reminderType) {
          $Setting = ClassRegistry::init('Setting');
          $reminderSetting = $Setting->find('first', array('conditions' => array('id' => $reminderType)));
          $reminderPeriod = $reminderSetting['Setting']['value']; 

          return $reminderPeriod;
     }

     function getEmailBcc() {
          $Setting = ClassRegistry::init('Setting');
          $reminderSetting = $Setting->find('first', array('conditions' => array('id' => 'reminder_email_cc')));
          $emails = explode(",", $reminderSetting['Setting']['value']);
          $emails = (Configure::read('debug') === 0 && !Configure::read('email-debug')) ? $emails : Configure::read('Email.debug_address');
          return $emails;
     }

     function checkReminderDue($dueDate, $reminderPeriod) {
          $sendReminder = false;
          $now = strtotime('now');

          $daysOutstanding = round((strtotime($dueDate) - $now) /3600/24);

          if ($daysOutstanding  == $reminderPeriod){
               $sendReminder = true;
          }

          return $sendReminder;
     }
 }