<?php
/**
 * Routes Configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
	Router::connectNamed(array(
		'status',
		'error',
		'date'
	), array('default' => true));

	Router::connect('/', array('controller' => 'dashboard', 'action' => 'index'));

	Router::connect('/login', array('controller' => 'users', 'action' => 'login', 'plugin' => 'octo_users'));
	Router::connect('/help', array('controller' => 'pages', 'action' => 'display', 'help'));
	Router::connect('/register', array('controller' => 'users', 'action' => 'register', 'plugin' => 'octo_users'));
	Router::connect('/registered', array('controller' => 'users', 'action' => 'success', 'plugin' => 'octo_users'));
	Router::connect('/request_password', array('controller' => 'users', 'action' => 'request_password', 'plugin' => 'octo_users'));
	Router::connect('/resend', array('controller' => 'users', 'action' => 'resend', 'plugin' => 'octo_users'));

	// Router::connect('/process/list/evaluate-cat-b', array('controller' => 'process', 'action' => 'list_process', 'process-slug' => 'evaluate'));
	Router::connect('/process/list/:process-slug/*', array('controller' => 'process', 'action' => 'list_process'));
	Router::connect('/process/action/:process-slug/:action-slug/:id/*', array('controller' => 'process', 'action' => 'perform_action'), array('id' => '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}'));
	Router::connect('/process/action/:process-slug/*', array('controller' => 'process', 'action' => 'perform_action'));
	Router::connect('/process/view/:process-slug/:id', array('controller' => 'process', 'action' => 'view'));
	Router::connect('/process/view/:process-slug/:id/sectionView:sectionView', array('controller' => 'process', 'action' => 'view'));
	Router::connect('/process/view/:process-slug/:id/*', array('controller' => 'process', 'action' => 'view'));
	Router::connect('/process/close/:process-slug/:flow-slug', array('controller' => 'process', 'action' => 'close'));
	Router::connect('/process/:process-slug/:id', array('controller' => 'process', 'action' => 'continue_process'), array('id' => '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}'));
	Router::connect('/process/:process-slug', array('controller' => 'process', 'action' => 'form'));
	Router::connect('/process/:process-slug/:flow-slug', array('controller' => 'process', 'action' => 'form'));
	Router::connect('/process/:process-slug/:flow-slug/:to-flow', array('controller' => 'process', 'action' => 'form'));

	Router::connect('/settings/list', array('controller' => 'settings', 'action' => 'index'));
	Router::connect('/settings/edit/:id', array('controller' => 'settings', 'action' => 'edit'));


	Router::connect('/reports/*', array('controller' => 'reports', 'action' => 'index'));

	Router::parseExtensions('json', 'xlsx', 'pdf', 'docx');