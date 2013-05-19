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
 * Utilizing functions from the initialization file, configure aspects of the 
 * application before we get up and running.
 */

// Call function to create the loader with our valid paths.
setup_loader(
	CORE_PATH . '/Loader.php',
	'Loader',
	'autoload',
	array(
		'core'			=> array('path' => CORE_PATH, 'search_sub_dir' => true),
		'utils'			=> array('path'	=> UTILS_PATH, 'search_sub_dir' => false),
		'models'		=> array('path'	=> MODEL_PATH, 'search_sub_dir' => true),
		'views'			=> array('path'	=> VIEW_PATH, 'search_sub_dir' => false),
		'view_includes'	=> array('path'	=> VIEW_INCLUDES_PATH, 'search_sub_dir' => true),
		'controllers'	=> array('path'	=> CONTROLLER_PATH, 'search_sub_dir' => true)
	),
	array(
		'dev_lib'		=> array('path' => DEVELOPMENT_LIBRARY_PATH, 'search_sub_dir' => true)
	)
);

// Call function to set our error handler for the application. Enter string 
// messages in the array for the second argument to ignore them if encountered.
if ( ! IS_MODE_DEBUG)
{
	setup_error_handler('showFatalErrorPage', array(null));
}

// Call function to set our class and method for uncaught exceptions.
set_uncaught_exception_handler('uncaughtException');

// Call function to compile LESS.
if ( ! IS_MODE_PRODUCTION)
{
	compile_less(
		'lessc', 
		LESS_IN_PATH . '/' . 'all.less', 
		LESS_OUT_PATH . '/' . 'style.css'
	);
}

// Call function to output concatenated files.
if (DOES_CONCATENATE)
{
	switch (CONCATENATE_TYPE)
	{
		case 'js':
			$content_type = 'Content-type: application/javascript';
			$path = JS_PATH . '/';
			$file_array = array(
				'paths-production.js'
			);
			break;			
		case 'css':
			$content_type = 'Content-type: text/css';
			$path = CSS_PATH . '/';
			$file_array = array(
				'style.css'
			);
			break;
	}
	
	output_concatenated_files('Concatenate', $content_type, $path, $file_array);
}

/* EOF application/config/config.php */