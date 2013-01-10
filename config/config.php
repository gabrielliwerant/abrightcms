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
 * Configuration file
 * 
 * Configure some aspects of the program before we get fully up and running such
 * as our autoloaders, and check whether or not we should install the database.
 */

/**
 * Configuration file
 * 
 * Configure some aspects of the program before we get fully up and running such
 * as our autoloaders, and check whether or not we should install the database.
 */

// PHP 5.3 sets magic quotes to off by default, but lower versions don't
if (PHP_VERSION < 5.3)
{	
	@set_magic_quotes_runtime(0);
}

require_once LIBRARY_PATH . '/Loader.php';

// Create the loader with our valid paths, saving the development path for later
$loader = new Loader(array(
	'library_path'			=> LIBRARY_PATH,
	'model_path'			=> MODEL_PATH,
	'app_model_path'		=> APP_MODEL_PATH,
	'view_path'				=> VIEW_PATH,
	'app_view_path'			=> APP_VIEW_PATH,
	'controller_path'		=> CONTROLLER_PATH,
	'app_controller_path'	=> APP_CONTROLLER_PATH
));

spl_autoload_register(array($loader, 'autoload'));
set_exception_handler(array(new MyException(), 'uncaughtException'));

// Development mode aspects are dealt with here
if ( ! IS_MODE_PRODUCTION)
{
	$loader->setAdditionalPath(DEVELOPMENT_PATH);
	$loader->setAdditionalPath(DEVELOPMENT_LIBRARY_PATH);
	
	$less_file_input	= 'all.less';
    $css_file_output	= 'style.css';

    lessc::ccompile(
		LESS_IN_PATH	. '/' . $less_file_input, 
        LESS_OUT_PATH	. '/' . $css_file_output,
		true
    );
}

// Create a database, get a database connection, and then run the install file
if ( ! IS_MODE_INSTALLED)
{
	if (DB_TYPE === 'mysql')
	{
		$mysql_connection = mysql_connect(DB_HOST, DB_USER, DB_PASS) or exit(DB_ERR_MSG);
		
		mysql_query("
			CREATE DATABASE 
			IF NOT EXISTS ". DB_NAME, $mysql_connection
		) or exit(DB_ERR_MSG);
	}
	else
	{		
		throw new MyException('Wrong Database Type for Establishing Connection.');
	}
	
	$db = new Database();

	require_once DEVELOPMENT_PATH . '/install.php';
}

/* EOF config/config.php */