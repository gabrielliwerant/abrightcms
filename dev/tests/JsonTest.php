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
	public function __construct()
	{
		$class_name = str_replace('Test', '', __CLASS__);
		
		require_once self::RELATIVE_PATH . '\config\settings.php';
		require_once self::RELATIVE_PATH . '\lib\\' . $class_name . '.php';
		
		$this->json = new Json();
	}
	
	/**
	 * Decode function takes a JSON formatted string and converts to regular 
	 * string, integer, array, mix.
	 */
	public function testJsonDecode()
	{
		$this->assertEquals(1, $this->json->getJsonDecode('1'));
		$this->assertEquals('foo', $this->json->getJsonDecode('"foo"'));
		$this->assertEquals(array('foo' => 'bar'), $this->json->getJsonDecode('{"foo":"bar"}'));
		$this->assertEquals(array('foo' => 1), $this->json->getJsonDecode('{"foo":1}'));
		$this->assertEquals(array('foo', 'bar', 'baz'), $this->json->getJsonDecode('["foo","bar","baz"]'));
		$this->assertEquals(array('foo' => 'bar', 'baz' => 1), $this->json->getJsonDecode('{"foo":"bar","baz":1}'));
	}
	
	/**
	 * Encode function takes a string, integer, array, or mix and conerts to a
	 * JSON encoded string.
	 */
	public function testJsonEncode()
	{
		$this->assertEquals('1', $this->json->getJsonEncode(1));
		$this->assertEquals('"foo"', $this->json->getJsonEncode('foo'));
		$this->assertEquals('{"foo":"bar"}', $this->json->getJsonEncode(array('foo' => 'bar')));
		$this->assertEquals('{"foo":1}', $this->json->getJsonEncode(array('foo' => 1)));
		$this->assertEquals('["foo","bar","baz"]', $this->json->getJsonEncode(array('foo', 'bar', 'baz')));
		$this->assertEquals('{"foo":"bar","baz":1}', $this->json->getJsonEncode(array('foo' => 'bar', 'baz' => 1)));
	}
	
	/**
	 * Convert string versions of true and false to their boolean counterparts.
	 */
	public function testStringValueConversionToBoolean()
	{
		$this->assertTrue($this->json->getStringValueAsBoolean('true'));
		$this->assertFalse($this->json->getStringValueAsBoolean('false'));
	}
}
// End of JsonTest Class

/* EOF dev/tests/JsonTest.php */