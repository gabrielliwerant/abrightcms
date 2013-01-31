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
 * JsonTest Class
 * 
 * @subpackage dev/tests
 * @author Gabriel Liwerant
 */
class JsonTest extends PHPUnit_Framework_TestCase
{
	const RELATIVE_PATH = '..\\';
	
	/**
	 * Call settings and load the class we're testing.
	 */	
	protected function setUp()
	{
		parent::setUp();
		
		$class_name = str_replace('Test', '', __CLASS__);
		
		require_once self::RELATIVE_PATH . 'config\settings.php';
		require_once self::RELATIVE_PATH . 'lib\\' . $class_name . '.php';
		require_once self::RELATIVE_PATH . 'lib\MyException.php';
		require_once self::RELATIVE_PATH . 'lib\ApplicationFactory.php';
		require_once self::RELATIVE_PATH . 'lib\Logger.php';
		
		$this->obj = new $class_name();
	}
	
	/**
	 * Destroy data after test is done.
	 */
	protected function tearDown()
	{
		parent::tearDown();
	}
	
	/**
	 * @expectedException			MyException
	 * @expectedExceptionMessage	Json Exception (Syntax error, malformed JSON)
	 */
	public function testJsonDecodeForBadInput()
	{
		$this->assertEquals('foo', $this->obj->getJsonDecode('foo'));
	}
	
	/**
	 * @todo we'll assert exception thrown here eventually, when I figure out
	 *		how to fail a json encoding.
	 */
	public function testJsonEncodeForBadInput()
	{
		//$this->assertEquals('"foo"', $this->obj->getJsonEncode('foo'));
	}
	
	/**
	 * Convert string versions of true to boolean true.
	 */
	public function testStringValueConversionToBooleanTrue()
	{
		$this->assertTrue($this->obj->getStringValueAsBoolean('true'));
	}
	
	/**
	 * Convert string version of false to boolean false.
	 */
	public function testStringValueConversionToBooleanFalse()
	{
		$this->assertFalse($this->obj->getStringValueAsBoolean('false'));
	}
	
	/**
	 * @expectedException			MyException
	 * @expectedExceptionMessage	Json Exception
	 */
	public function testStringValueConversionToBooleanTrueForBadInput()
	{
		$this->assertTrue($this->obj->getStringValueAsBoolean('foo'));
	}
	
	/**
	 * @expectedException			MyException
	 * @expectedExceptionMessage	Json Exception
	 */
	public function testStringValueConversionToBooleanFalseForBadInput()
	{
		$this->assertFalse($this->obj->getStringValueAsBoolean('foo'));
	}
}
// End of JsonTest Class

/* EOF dev/tests/JsonTest.php */