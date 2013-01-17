<?php

/**
 * A Bright CMS
 * 
 * Core MVC/CMS framework used in TaskVolt and created for lightweight, custom
 * web applications.
 * 
 * @package A Bright CMS
 * @author Gabriel Liwerant
 */

/**
 * Test Class
 * 
 * @subpackage
 * @author Gabriel Liwerant
 */
class Test extends PHPUnit_Framework_TestCase
{
	const RELATIVE_PATH = '..\..';
	
	//
	//
	//
	public function __construct()
	{
		//
	}
	
	//
	//
	//
	protected function setUp()
	{
		parent::setUp();
		
		$class_name = str_replace('Test', '', __CLASS__);
		
		require_once self::RELATIVE_PATH . '\config\settings.php';
		require_once self::RELATIVE_PATH . '\lib\\' . $class_name . '.php';
		
		$this->obj = new $class_name();		
	}
}
// End of Test Class

/* EOF lib/Test.php */