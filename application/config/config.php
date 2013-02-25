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
 * Configuration file
 * 
 * Configure some aspects of the program before we get fully up and running such
 * as our autoloaders, and check whether or not we should install the database.
 */

// PHP 5.3 sets magic quotes to off by default, but lower versions don't and
// magic quotes are evil, so set them off here.
if (PHP_VERSION < 5.3)
{	
	@set_magic_quotes_runtime(false);
}

// Create the loader with our valid paths.
require_once CORE_PATH . '/Loader.php';
$loader = new Loader(array(
	'core'			=> array('path' => CORE_PATH, 'search_sub_dir' => true),
	'utils'			=> array('path'	=> UTILS_PATH, 'search_sub_dir' => false),
	'models'		=> array('path'	=> MODEL_PATH, 'search_sub_dir' => true),
	'views'			=> array('path'	=> VIEW_PATH, 'search_sub_dir' => false),
	'controllers'	=> array('path'	=> CONTROLLER_PATH, 'search_sub_dir' => true)
));
spl_autoload_register(array($loader, 'autoload'));

// Set default time zone for PHP date functions
date_default_timezone_set(DEFAULT_TIME_ZONE);

// Development-only aspects are dealt with here.
if ( ! IS_MODE_PRODUCTION)
{
	// Since we're in development mode, add development path to loader.
	$loader->setAdditionalPath(
		'dev_lib', 
		array('path' => DEVELOPMENT_LIBRARY_PATH, 'search_sub_dir' => true)
	);
	
	// Compile our LESS code!
	$less_file_input = 'all.less';
    $css_file_output = 'style.css';
	lessc::ccompile(
		LESS_IN_PATH	. '/' . $less_file_input, 
        LESS_OUT_PATH	. '/' . $css_file_output,
		true
    );
	
	// If we want to concatenate files, we can output them to the header one
	// after the other, called here.
	if (DOES_CONCATENATE)
	{
		$js_files = array(
			'paths_production.js',
			'modernizr-custom.js'
		);
		$css_files = array(
			'reset.css',
			'style.css'
		);
		
		switch (CONCATENATE_TYPE)
		{
			case 'js':
				$js_concat = new Concatenate(
					'Content-type: application/javascript', 
					FILE_ROOT_PATH . '/dev/public/js/', 
					$js_files
				);
				
				$js_concat->loadPageConcatenator();
				
				break;			
			case 'css':
				$css_concat = new Concatenate(
					'Content-type: text/css', 
					FILE_ROOT_PATH . '/dev/public/css/', 
					$css_files
				);
				
				$css_concat->loadPageConcatenator();
				
				break;
		}
	}
}

// Set class and method for uncaught exceptions
set_exception_handler(array(ApplicationFactory::makeException(), 'uncaughtException'));

// Error reporting levels
if (IS_MODE_DEBUG)
{
	error_reporting(E_ALL);
}
else
{
	error_reporting(0);
	
	// Because error reporting is off, we need a way to register errors
	register_shutdown_function(array(
		new ErrorHandler(
			ApplicationFactory::makeLogger(), 
			ApplicationFactory::makeEmail()
		),
		'showFatalErrorPage')
	);
}

/* EOF application/config/config.php */