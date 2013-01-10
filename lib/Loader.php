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
 * Loader Class
 * 
 * We use this with spl_autoload_register to load our class files.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class Loader
{
	/**
	 * Stored paths for use in our autoloader method.
	 *
	 * @var array $path
	 */
	public static $path = array();
	
	/**
	 * The constructor stores the valid paths in our class for later.
	 * 
	 * @param string array $path_arr Paths to store for autoloading later
	 */
	public function __construct($path_arr)
	{
		self::$path = $path_arr;
	}
	
	/**
	 * Set additional paths for our autoloader to call upon. Useful for 
	 * assigning conditional paths after construction, like development paths.
	 *
	 * @param string $path 
	 */
	public function setAdditionalPath($path)
	{
		self::$path[] = $path;
	}
	
	/**
	 * The method to find the proper paths for autoloading our classes.
	 * 
	 * We run through the list of paths given in the class property and build 
	 * the full class path from those.
	 * 
	 * @param type $class_name The class to load
	 */
	public static function autoload($class_name)
	{
		foreach (self::$path as $value)
		{
			$file_path = $value . '/' . $class_name . '.php';
			
			if (file_exists($file_path))
			{
				require $file_path;
			}
		}
	}
}
// End of Loader Class

/* EOF lib/Loader.php */