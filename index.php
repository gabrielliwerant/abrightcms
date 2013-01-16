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
 * of the bootstrap class.
 */

// Define the full absolute directory file path
define('ABSOLUTE_ROOT_PATH', dirname(__FILE__));

// Load the initial config files
require_once ABSOLUTE_ROOT_PATH . '/config/settings.php';
require_once ABSOLUTE_ROOT_PATH . '/config/paths.php';
require_once ABSOLUTE_ROOT_PATH . '/config/database.php';
require_once ABSOLUTE_ROOT_PATH . '/config/config.php';

// Create the main application object which also loads the approprate 
// controller and calls the appropriate method (with any parameters). We wrap 
// in a try catch block to hide system exceptions in a production environment.
try
{
	$application_factory = new ApplicationFactory(STORAGE_TYPE);
	
	new Bootstrap($application_factory, $_GET);
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