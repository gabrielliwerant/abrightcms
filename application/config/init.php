<?php if ( ! defined('DENY_ACCESS')) exit('403: No direct file access allowed');

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
 * Initialization file
 * 
 * Initialize some aspects of the application we'll need to be fully functional
 * including required functions.
 */

// Set error reporting levels.
if (IS_MODE_DEBUG)
{
	error_reporting(E_ALL);
}
else
{
	error_reporting(0);
}

// PHP 5.3 sets magic quotes to off by default, but lower versions don't and
// magic quotes are evil, so set them off here.
if (PHP_VERSION < 5.3)
{	
	@set_magic_quotes_runtime(false);
}

// Set default time zone for PHP date functions.
date_default_timezone_set(DEFAULT_TIME_ZONE);

/**
 * Instantiate our autoloader and set it with required paths to check.
 *
 * @param string $loader_path
 * @param string $loader_class_name
 * @param string $loader_method_name
 * @param array $paths_to_set 
 * @param array $dev_paths_to_set
 */
function setup_loader($loader_path, $loader_class_name, $loader_method_name, $paths_to_set, $dev_paths_to_set)
{
	require_once $loader_path;
	
	$loader = new $loader_class_name($paths_to_set);
	
	spl_autoload_register(array($loader, $loader_method_name));
	
	// Since we're in development mode, add development path to loader.
	if ( ! IS_MODE_PRODUCTION)
	{
		$loader->setAdditionalPath($dev_paths_to_set);
	}
}

/**
 * Instantiate error handler, set it with dependencies, and set it as our 
 * default shutdown function in the event of application errors.
 *
 * @param string $error_page_name 
 * @param array $ignore_messages
 */
function setup_error_handler($error_page_name, $ignore_messages)
{
	register_shutdown_function(array(
		new ErrorHandler(
			ApplicationFactory::makeLogger(), 
			ApplicationFactory::makeEmail(),
			$ignore_messages
		),
		$error_page_name)
	);
}

/**
 * Set class and method for uncaught exceptions.
 *
 * @param string $method_name 
 */
function set_uncaught_exception_handler($method_name)
{
	set_exception_handler(array(ApplicationFactory::makeException(), $method_name));
}

/**
 * Allows us to compile LESS code into CSS.
 *
 * @param string $less_class_name
 * @param string $less_file_input_path
 * @param string $css_file_output_path 
 */
function compile_less($less_class_name, $less_file_input_path, $css_file_output_path)
{
	$lessc = new $less_class_name();
	
	$lessc->compileFile($less_file_input_path, $css_file_output_path);
}

/**
 * Concatenate and output files using out concatenate class.
 *
 * @param string $concatenate_class_name
 * @param string $content_type
 * @param string $path
 * @param array $file_arr 
 */
function output_concatenated_files($concatenate_class_name, $content_type, $path, $file_arr)
{
	$concatenate = new $concatenate_class_name($content_type, $path, $file_arr);
	
	$concatenate->loadPageConcatenator();
}