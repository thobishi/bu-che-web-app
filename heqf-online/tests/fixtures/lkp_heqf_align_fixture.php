<?php
/* LkpHeqfAlign Fixture generated on: 2011-02-16 12:22:08 : 1297851728 */
class LkpHeqfAlignFixture extends CakeTestFixture {
	var $name = 'LkpHeqfAlign';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'heqf_align_desc' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 'Lorem ipsum dolor sit ame',
			'heqf_align_desc' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>