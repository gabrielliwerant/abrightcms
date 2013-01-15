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
class Test
{
	const MAIN_PATH			= 'C:\WampServer2\www\abrightcms';
	const LIBRARY_PATH		= 'C:\WampServer2\www\abrightcms\lib';
	const MODEL_PATH		= 'C:\WampServer2\www\abrightcms\lib';
	const VIEW_PATH			= 'C:\WampServer2\www\abrightcms\lib';
	const CONTROLLER_PATH	= 'C:\WampServer2\www\abrightcms\lib';
	
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
	public function init()
	{
		require_once self::MAIN_PATH . '\config\settings.php';
		require_once self::MAIN_PATH . '\config\paths.php';
		require_once self::MAIN_PATH . '\config\config.php';
	}
}
// End of Test Class

/* EOF lib/Test.php */