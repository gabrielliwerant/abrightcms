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
 * The file that starts it all.
 * 
 * The index file must first load the configuration files which will define some
 * constants and initial conditions which are necessary for the program.
 * 
 * Once that step is completed, the program will run as an object instantiation
 * of the application class/front controller.
 * 
 * @todo write unit tests for each library class
 * @todo create Xml class and test for xml files
 * @todo also catch exceptions deeper in the code
 */

// Define the full absolute directory file path
define('ABSOLUTE_ROOT_PATH', dirname(__FILE__));
// Define the configuration path based on the absolute path
define('CONFIG_PATH', ABSOLUTE_ROOT_PATH . '/application/config');

// Load the initial configuration files
require_once CONFIG_PATH . '/settings.php';
require_once CONFIG_PATH . '/paths.php';
require_once CONFIG_PATH . '/config.php';

// Create the main application object with its dependencies. We wrap in a 
// try/catch block to hide system exceptions in a production environment.
try
{
	$app_factory	= new ApplicationFactory(STORAGE_TYPE);
	$app			= new Application($app_factory, $_GET);
}
catch (MyException $e)
{
	if (IS_MODE_PRODUCTION)
	{
		exit($e->caughtException());
	}
	else
	{
		$e->caughtException();
	}
}

/* EOF index.php */