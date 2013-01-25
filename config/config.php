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
require_once LIBRARY_PATH . '/Loader.php';
$loader = new Loader(array(
	'library_path'			=> LIBRARY_PATH,
	'model_path'			=> MODEL_PATH,
	'view_path'				=> VIEW_PATH,
	'controller_path'		=> CONTROLLER_PATH
));
spl_autoload_register(array($loader, 'autoload'));

// Development-only aspects are dealt with here.
if ( ! IS_MODE_PRODUCTION)
{
	// Since we're in development mode, add development path to loader.
	$loader->setAdditionalPath(DEVELOPMENT_LIBRARY_PATH);
	
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
					FILE_ROOT_PATH . '/dev/js/', 
					$js_files
				);
				
				$js_concat->loadPageConcatenator();
				
				break;			
			case 'css':
				$css_concat = new Concatenate(
					'Content-type: text/css', 
					FILE_ROOT_PATH . '/dev/css/', 
					$css_files
				);
				
				$css_concat->loadPageConcatenator();
				
				break;
		}
	}
}

// Set class and method for uncaught exceptions
set_exception_handler(array(new MyException(ApplicationFactory::makeLogger()), 'uncaughtException'));

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
			new Email()
		),
		'showFatalErrorPage')
	);
}

/* EOF config/config.php */