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
 * FormTest Class
 * 
 * @subpackage dev/tests
 * @author Gabriel Liwerant
 */
class FormTest extends PHPUnit_Framework_TestCase
{
	const RELATIVE_PATH = '..\..';

	/**
	 * Call settings and load the class we're testing.
	 */	
	protected function setUp()
	{
		parent::setUp();
		
		$class_name		= str_replace('Test', '', __CLASS__);
		
		require_once self::RELATIVE_PATH . '\config\settings.php';
		require_once self::RELATIVE_PATH . '\lib\\' . $class_name . '.php';
		
		$this->obj = new $class_name();
	}
	
	/**
	 * Destroy data after test is done.
	 */
	protected function tearDown()
	{
		unset($this->obj);
		
		parent::tearDown();
	}
}
// End of FormTest Class

/* EOF dev/tests/FormTest.php */