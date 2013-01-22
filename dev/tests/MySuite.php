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
 * MySuite Class
 * 
 * @subpackage dev/tests
 * @author Gabriel Liwerant
 */
class MySuite extends PHPUnit_Framework_TestSuite
{
	const RELATIVE_PATH = '..\..';
	
	/**
	 * Call the parent.
	 */	
	protected function setUp()
	{
		parent::setUp();
		
		require_once self::RELATIVE_PATH . '\config\settings.php';
		require_once self::RELATIVE_PATH . '\dev\tests\JsonTest.php';
		require_once self::RELATIVE_PATH . '\lib\MyException.php';
	}
	
	/**
	 * Call the parent.
	 */
	protected function tearDown()
	{
		parent::tearDown();
	}
	
	public static function suite()
    {
        return new MySuite('JsonTest');
    }
}
// End of MySuite Class

/* EOF dev/tests/MySuite.php */