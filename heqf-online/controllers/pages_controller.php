<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/958/The-Pages-Controller
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('display', 'download_help');
	}
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */

	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}

	public function download_help($document) {
		$name = '';
		$file = '';

		if (!empty($document)) {
			switch($document){
				case 'manual-cheadmin':
					$file = 'heqf_online_user_manual.pdf';
					$name = 'HEQF_online_che_admin_manual';
					break;
				case 'manual-instadmin':
					$file = 'CHE - User Manual V2.0(Institution Administrator).pdf';
					$name = 'HEQF_online_inst_admin_manual';
					break;
				case 'manual-instuser':
					$file = 'Council for Higher Education - User Manual V1.0(Institutional User).pdf';
					$name = 'HEQF_online_inst_user_manual';
					break;
				case 'revised':
					$file = 'Revised_HEQF_Sept2011.pdf';
					$name = 'Revised HEQF September 2011';
					break;
				case 'discussion':
					$file = 'HEQF_review_discussion.pdf';
					$name = 'HEQF review discussion';
					break;
				case 'cesm':
					$file = 'CESM Final 19-01-09 CHANGES.pdf';
					$name = 'CESM Final 19-01-09 CHANGES';
					break;
				case 'gfetqsf':
					$file = 'GG- Publication of the GFETQSF and HEQSF of the NQF.pdf';
					$name = 'GG- Publication of the GFETQSF and HEQSF of the NQF';
					break;
				case 's2_valid':
					$file = 'heqsf_alignment_s2_validation_check.pdf';
					$name = 'HEQSF Alignment Section 2 validation checklist';
					break;
				case 'evaluate_catB':
					$file = 'How_to_evaluate_category_B_applications.pdf';
					$name = 'Evaluate category B applications';
					break;
				case 'review':
					$file = 'How_to_review_category_B_applications.pdf';
					$name = 'Review Category B applications';
					break;
				}
		}

		Configure::write('debug', 0);

		$this->view = 'Media';
		$pathInfo = pathinfo(WWW_ROOT . 'files/help/' . $file);
		$params = array(
				'id' => $file,
				'name' => $name,
				'download' => true,
				'extension' => strtolower($pathInfo['extension']),
				'mimeType' => $this->_mimeTypes,
				'path' => 'files/help/'
		);

		$this->set($params);
	}
}
