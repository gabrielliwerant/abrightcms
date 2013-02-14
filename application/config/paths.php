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
if (IS_MODE_PRODUCTION)
{
	define('FILE_ROOT_PATH', '../' . DOMAIN_NAME);
}
else
{
	define('FILE_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . DOMAIN_NAME);
}

// Set up paths derived from the root
define('APPLICATION_PATH', FILE_ROOT_PATH . '/application');
define('SYSTEM_PATH', FILE_ROOT_PATH . '/system');
define('MODEL_PATH', APPLICATION_PATH . '/models');
define('VIEW_PATH', APPLICATION_PATH . '/views');
define('CONTROLLER_PATH', APPLICATION_PATH . '/controllers');
define('CORE_PATH', SYSTEM_PATH . '/core');
define('UTILS_PATH', APPLICATION_PATH . '/utils');
define('LOGS_PATH', APPLICATION_PATH . '/logs');

// Set up paths that depend upon development environment mode
if (IS_MODE_PRODUCTION)
{
	define('HTTP_ROOT_PATH', 'http://' . DOMAIN_NAME);
	define('HTTP_APPLICATION_PATH', HTTP_ROOT_PATH . '/application');
	
	define('PUBLIC_PATH', HTTP_APPLICATION_PATH . '/public');
	define('JSON_PATH', APPLICATION_PATH . '/json');
	define('XML_PATH', APPLICATION_PATH . '/xml');
}
else
{
	define('HTTP_ROOT_PATH', 'http://localhost/' . DOMAIN_NAME);
	define('HTTP_APPLICATION_PATH', HTTP_ROOT_PATH . '/application');
	
	define('PUBLIC_PATH', HTTP_ROOT_PATH . '/dev/public');
	define('DEVELOPMENT_PATH', FILE_ROOT_PATH . '/dev');
	define('DEVELOPMENT_LIBRARY_PATH', DEVELOPMENT_PATH . '/lib');
	define('TESTS_PATH', DEVELOPMENT_PATH . '/tests');
	define('JSON_PATH', DEVELOPMENT_PATH . '/json');
	define('XML_PATH', DEVELOPMENT_PATH . '/xml');
	define('LESS_IN_PATH', DEVELOPMENT_PATH . '/less');
	define('LESS_OUT_PATH', DEVELOPMENT_PATH . '/public/css');
}

// Set up other paths
define('JS_PATH', PUBLIC_PATH . '/js');
define('CSS_PATH', PUBLIC_PATH . '/css');
define('IMAGES_PATH', PUBLIC_PATH . '/images');
define('TEMPLATE_PATH', VIEW_PATH . '/_template');
define('ERROR_HANDLER_PAGE_PATH', HTTP_APPLICATION_PATH . '/views/_template/error.html');

/* EOF application/config/paths.php */