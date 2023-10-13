<div id="sidebar">
	<?php
		$reportHeading = '';
		if ($this->AuthLinks->checkPermission('update', 'Permissions', 'OctoUsers')) {
			$sidebar[] = $this->AuthLinks->link('Configure permissions', array('admin' => true, 'controller' => 'permissions', 'plugin' => 'octo_users', 'action' => 'edit'));
		}
		if ($this->AuthLinks->checkPermission('update', 'Roles', 'OctoUsers')) {
			$sidebar[] = $this->AuthLinks->link('Configure roles', array('admin' => true, 'controller' => 'roles', 'plugin' => 'octo_users'));
		}
		if ($this->AuthLinks->checkPermission('update', 'AvailableControllers', 'OctoUsers')) {
			$sidebar[] = $this->AuthLinks->link('Configure controllers', array('admin' => true, 'controller' => 'available_controllers', 'plugin' => 'octo_users'));
		}
		if ($this->AuthLinks->checkPermission('update', 'Rules')) {
			$sidebar[] = $this->Html->link('Clear system cache', array('action' => 'clear', 'controller' => 'cache', 'plugin' => ''));
		}
		if ($this->AuthLinks->checkPermission('update', 'Rules')) {
			$sidebar[] = $this->AuthLinks->link('Manage validation rules', array('admin' => true, 'controller' => 'rules', 'plugin' => ''));
		}
		/*
			Permissions for the report link
		*/
		$user = Auth::get();
		$reportRoles = Configure::read('Report.Roles');

		if ($this->AuthLinks->checkPermission('read', 'report', 'process')) {
			$reportHeading = '<h2>Reports</h2>';
			foreach ($user['Role'] as $role) {
				if (in_array($role['id'], $reportRoles['heqf-app-alignment'])) {
					$reportBar[] = $this->Html->link('HEQSF alignment', array('controller' => 'reports', 'action' => 'index', 'heqf-app-alignment', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['outcome-summary'])) {
					$reportBar[] = $this->Html->link('Outcome summary per institution', array('controller' => 'reports', 'action' => 'index', 'outcome-summary', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['list-outcomes'])) {
					$reportBar[] = $this->Html->link('List of outcomes per institution', array('controller' => 'reports', 'action' => 'index', 'list-outcomes', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['heqf-data-dump'])) {
					$reportBar[] = $this->Html->link('HEQSF data dump', array('controller' => 'reports', 'action' => 'index', 'heqf-data-dump', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['letter-data'])) {
					$reportBar[] = $this->Html->link('Letter and Data aligning report', array('controller' => 'reports', 'action' => 'index', 'letter-data', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['letter-verifications'])) {
					$reportBar[] = $this->Html->link('Letter verifications', array('controller' => 'reports', 'action' => 'index', 'letter-verifications', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['heqsf-app-totals'])) {
					$reportBar[] = $this->Html->link('HEQSF totals report', array('controller' => 'reports', 'action' => 'index', 'heqsf-app-totals', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['reminders'])) {
					$reportBar[] = $this->Html->link('Evaluator/Reviewer reminder report', array('controller' => 'reports', 'action' => 'index', 'reminders', 'plugin' => '', 'admin' => false));
				}

				if (in_array($role['id'], $reportRoles['outcome-alignment-applications'])) {
					$reportBar[] = $this->Html->link('HEQSF alignment outcomes per institution', array('controller' => 'reports', 'action' => 'index', 'outcome-alignment-applications', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['complete-applications'])) {
					$reportBar[] = $this->Html->link('Complete programme list', array('controller' => 'reports', 'action' => 'index', 'complete-applications', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['institution-offerings'])) {
					$reportBar[] = $this->Html->link('Offerings per institution', array('controller' => 'reports', 'action' => 'index', 'institution-offerings', 'plugin' => '', 'admin' => false));
				}
				if (in_array($role['id'], $reportRoles['institution-submissions'])) {
					$reportBar[] = $this->Html->link('Submissions per institution', array('controller' => 'reports', 'action' => 'index', 'institution-submissions', 'plugin' => '', 'admin' => false));
				}
				/*if (in_array($role['id'], $reportRoles['institution-all'])) {
					$reportBar[] = $this->Html->link('All per institution', array('controller' => 'reports', 'action' => 'index', 'institution-all', 'plugin' => '', 'admin' => false));
				}*/
			}
		}

		$user = Auth::get();
		if (empty($user)) {
			echo $this->element('login_box', array('plugin' => 'OctoUsers'));
		} elseif (!empty($sidebar) && is_array($sidebar)) {
			$sidebarHeading = '<h2>Actions</h2>';

			$sectionList = '';
			if (!empty($sidebar['Sections'])) {
				$sectionList = $this->Html->nestedList($sidebar['Sections'], array('class' => 'sections'));
				unset($sidebar['Sections']);
			}

			$actionList = $this->Html->nestedList($sidebar, array('class' => 'action-sidebar'));

			echo $sidebarHeading . $actionList . $sectionList;
		}

		if (!empty($reportHeading) && !empty($reportBar)) {
			$reportList = $this->Html->nestedList($reportBar, array('class' => 'action-sidebar'));
			echo $reportHeading . $reportList;
		}
		?>
</div>