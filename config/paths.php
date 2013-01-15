<?php if ( ! defined('DENY_ACCESS')) exit('403: No direct file access allowed');

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
 * Path constants
 * 
 * Sets the path constants we'll need throughout the program, including some
 * functions to help us determine those paths.
 */

// Set up the root paths
define('DOMAIN_NAME', 'abrightcms');
if (IS_MODE_PRODUCTION)
{
	define('FILE_ROOT_PATH', '../' . DOMAIN_NAME);
}
else
{
	define('FILE_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . DOMAIN_NAME);
}

// Set up paths derived from the root
define('MODEL_PATH', FILE_ROOT_PATH . '/models');
define('VIEW_PATH', FILE_ROOT_PATH . '/views');
define('CONTROLLER_PATH', FILE_ROOT_PATH . '/controllers');
define('LIBRARY_PATH', FILE_ROOT_PATH . '/lib');
define('LOGS_PATH', FILE_ROOT_PATH . '/logs');

// Set up paths that depend upon development environment mode
if (IS_MODE_PRODUCTION)
{
	define('HTTP_ROOT_PATH', 'http://' . DOMAIN_NAME);
	define('PUBLIC_PATH', HTTP_ROOT_PATH . '/public');
	define('JSON_PATH', FILE_ROOT_PATH . '/json');
	define('XML_PATH', FILE_ROOT_PATH . '/xml');
	
	define('JS_PATH', PUBLIC_PATH . '/js');
	define('CSS_PATH', PUBLIC_PATH . '/css');
}
else
{
	define('HTTP_ROOT_PATH', 'http://localhost/' . DOMAIN_NAME);
	define('PUBLIC_PATH', HTTP_ROOT_PATH . '/public');
	define('DEVELOPMENT_PATH', FILE_ROOT_PATH . '/dev');
	define('DEVELOPMENT_LIBRARY_PATH', DEVELOPMENT_PATH . '/lib');
	define('TESTS_PATH', DEVELOPMENT_PATH . '/tests');
	define('JSON_PATH', DEVELOPMENT_PATH . '/json');
	define('XML_PATH', DEVELOPMENT_PATH . '/xml');
	define('LESS_IN_PATH', DEVELOPMENT_PATH . '/less');
	define('LESS_OUT_PATH', DEVELOPMENT_PATH . '/css');
	
	define('JS_PATH', HTTP_ROOT_PATH . '/dev/js');
	define('CSS_PATH', HTTP_ROOT_PATH . '/dev/css');
}

// Set up other paths
define('APP_MODEL_PATH', MODEL_PATH . '/app');
define('APP_VIEW_PATH', VIEW_PATH . '/_app');
define('APP_CONTROLLER_PATH', CONTROLLER_PATH . '/app');
define('TEMPLATE_PATH', VIEW_PATH . '/_template');
define('IMAGES_PATH', PUBLIC_PATH . '/images');
define('ERROR_HANDLER_PAGE_PATH', HTTP_ROOT_PATH . '/views/_template/error.html');

/* EOF config/paths.php */