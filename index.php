<?php 

/**
 * A Bright CMS
 * 
 * Open source, lightweight, web application framework and content management 
 * system in PHP.
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
 * @todo catch exceptions deeper in the code
 * @todo determine what to put for @package docblock comments and how to change
 *		it everywhere with regex.
 * @todo add @license MIT throughout
 * 
 * @todo make re-usable form/contact controller
 * @todo make a way for us to build an anchor out of copyright holder automatically
 * @todo www and query string do not redirect properly in .htaccess
 * @todo make RESTful by using request method to predict API (index in the case of GET)
 * @todo make note in readme for images about apple touch stuff
 * @todo deal with new git push in git 2.0
 * @todo consider router class (or method?) that allows redirection from anywhere with header and exit, etc.
 * @todo make xml-compatible version of blog template
 */

// Define the full absolute directory file path
define('ABSOLUTE_ROOT_PATH', dirname(__FILE__));
// Define the configuration path based on the absolute path
define('CONFIG_PATH', ABSOLUTE_ROOT_PATH . '/application/config');

// Load the initial configuration files
require_once CONFIG_PATH . '/settings.php';
require_once CONFIG_PATH . '/paths.php';
require_once CONFIG_PATH . '/init.php';
require_once CONFIG_PATH . '/config.php';

// Create the main application object with its dependencies. We wrap in a 
// try/catch block to hide system exceptions in a production environment.
try
{
	//Debug::printArray($_SERVER['REQUEST_URI']);
	//Debug::printArray($_GET);
	$app_factory	= new ApplicationFactory(STORAGE_TYPE, HAS_DATABASE);
	$app			= new Application($app_factory, $_GET);
}
catch (MyException $e)
{
	IS_MODE_PRODUCTION ? exit($e->caughtException()) : $e->caughtException();
}
catch (Exception $e)
{
	$msg = $e->getMessage() . '. Exception code: #' . $e->getCode();
	
	IS_MODE_PRODUCTION ? exit($msg) : print($msg);
}

/* EOF index.php */