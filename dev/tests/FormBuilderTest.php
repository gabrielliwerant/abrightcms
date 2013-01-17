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
 * FormBuilderTest Class
 * 
 * @subpackage dev/tests
 * @author Gabriel Liwerant
 */
class FormBuilderTest extends PHPUnit_Framework_TestCase
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
		
		$this->obj = new $class_name('foo', 'bar');
		
		$this->obj
			->setFieldMeta('foo', array('bar'))
			->setLabel('foo', 'bar')
			->setInput('foo', 'foo', '1', 'hidden', 'bar', '1',	true, 'icon-asterisk')
			->setTextArea('baz', 'baz', true, 'icon-asterisk')
			->setSelect('qux', array('foo' => 'foo', 'bar' => 'bar'), 'qux', true, 'icon-asterisk')
			->setFieldMeta('email', array('is_email' => '1'));
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
	 * After setting field meta data in setUp, check that we can retrieve it.
	 */
	public function testGetFieldMetaAfterSet()
	{
		$this->assertEquals(
			array(
				'foo'	=> array(0 => 'bar'), 
				'email'	=> array('is_email' => '1')
			), 
			$this->obj->getAllFieldMeta()
		);
		
		$this->assertEquals(array(0 => 'bar'), $this->obj->getFieldMeta('foo'));
	}
	
	/**
	 * After setting label data in setUp, check that we can retrieve it.
	 */
	public function testGetLabelMatchingFieldKeyAfterSet()
	{
		$this->assertEquals('<label for="foo">bar</label>', $this->obj->getLabelMatchingFieldKey('foo'));
	}
	
	/**
	 * After setting input field data in setUp, check that we can retrieve it.
	 */
	public function testGetInputFieldAfterSet()
	{
		$this->assertEquals('<input name="foo" id="foo" maxlength="1" type="hidden" value="bar" size="1" class="required"/><i class="icon-asterisk"></i>', $this->obj->getField('foo'));
	}
	
	/**
	 * After setting textarea field data in setUp, check that we can retrieve it.
	 */
	public function testGetTextFieldAfterSet()
	{
		$this->assertEquals('<textarea name="baz" id="baz" class="required"></textarea><i class="icon-asterisk"></i>', $this->obj->getField('baz'));
	}
	
	/**
	 * After setting select field data in setUp, check that we can retrieve it.
	 */
	public function testGetSelectFieldAfterSet()
	{
		$this->assertEquals('<select name="qux" id="qux" class="required"><option value="foo">foo</option><option value="bar">bar</option></select><i class="icon-asterisk"></i>', $this->obj->getField('qux'));
	}
	
	/**
	 * After setting form data in setUp and calling some fields here, check that 
	 * we can retrieve the form.
	 */
	public function testGetFormAfterSet()
	{
		$fields = $this->obj->getLabelMatchingFieldKey('foo') . $this->obj->getField('foo') . $this->obj->getField('baz') . $this->obj->getField('qux');
		
		$this->assertEquals(
			'<form action="foo" method="bar" name="foo" id="foo" ><label for="foo">bar</label><input name="foo" id="foo" maxlength="1" type="hidden" value="bar" size="1" class="required"/><i class="icon-asterisk"></i><textarea name="baz" id="baz" class="required"></textarea><i class="icon-asterisk"></i><select name="qux" id="qux" class="required"><option value="foo">foo</option><option value="bar">bar</option></select><i class="icon-asterisk"></i></form>',
			$this->obj->getForm($fields, 'foo', 'foo')
		);
	}
	
	/**
	 * After setting email meta data in setUp, check that we can retrieve it 
	 * when we submit email information, and check that we get false if we can't.
	 */
	public function testFindUserEnteredEmailAfterSet()
	{
		$this->assertEquals('foo@bar.baz', $this->obj->findUserEnteredEmail(array('email' => 'foo@bar.baz')));
		$this->assertFalse($this->obj->findUserEnteredEmail(array('name' => 'foo')));
	}
}
// End of FormBuilderTest Class

/* EOF dev/tests/FormBuilderTest.php */