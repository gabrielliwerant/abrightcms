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
 * Path constants
 * 
 * Sets the path constants we'll need throughout the program, including some
 * functions to help us determine those paths.
 */

// Set up the root paths
define('DOMAIN_NAME', 'abrightcms.com');
define('FILE_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . DOMAIN_NAME);

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
	define('JSON_PATH', FILE_ROOT_PATH . '/json');
}
else
{
	define('HTTP_ROOT_PATH', 'http://localhost/' . DOMAIN_NAME);
	define('DEVELOPMENT_PATH', FILE_ROOT_PATH . '/dev');
	define('DEVELOPMENT_LIBRARY_PATH', DEVELOPMENT_PATH . '/lib');
	define('JSON_PATH', DEVELOPMENT_PATH . '/json');
	define('LESS_IN_PATH', DEVELOPMENT_PATH . '/less');
	define('LESS_OUT_PATH', FILE_ROOT_PATH . '/public/css');
}

// Set up subpaths and public paths
define('APP_MODEL_PATH', MODEL_PATH . '/app');
define('APP_VIEW_PATH', VIEW_PATH . '/_app');
define('APP_CONTROLLER_PATH', CONTROLLER_PATH . '/app');
define('TEMPLATE_PATH', VIEW_PATH . '/_template');
define('PUBLIC_PATH', HTTP_ROOT_PATH . '/public');
define('CSS_PATH', PUBLIC_PATH . '/css');
define('JS_PATH', PUBLIC_PATH . '/js');

/* EOF config/paths.php */