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
	
	/**
	 * Decode function takes a JSON formatted string and converts to regular 
	 * string, integer, array, mix.
	 */
	public function testJsonDecode()
	{
		$this->assertEquals('foo', $this->obj->getJsonDecode('"foo"'));
		$this->assertEquals(array('foo' => 1), $this->obj->getJsonDecode('{"foo":1}'));
		$this->assertEquals(array('foo', 'bar', 'baz'), $this->obj->getJsonDecode('["foo","bar","baz"]'));
	}
	
	/**
	 * Encode function takes a string, integer, array, or mix and conerts to a
	 * JSON encoded string.
	 */
	public function testJsonEncode()
	{
		$this->assertEquals('"foo"', $this->obj->getJsonEncode('foo'));
		$this->assertEquals('{"foo":1}', $this->obj->getJsonEncode(array('foo' => 1)));
		$this->assertEquals('["foo","bar","baz"]', $this->obj->getJsonEncode(array('foo', 'bar', 'baz')));
	}
	
	/**
	 * Convert string versions of true and false to their boolean counterparts.
	 */
	public function testStringValueConversionToBoolean()
	{
		$this->assertTrue($this->obj->getStringValueAsBoolean('true'));
		$this->assertFalse($this->obj->getStringValueAsBoolean('false'));
	}
}
// End of JsonTest Class

/* EOF dev/tests/JsonTest.php */