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
 * ApplicationFactory Class
 * 
 * @subpackage
 * @author Gabriel Liwerant
 */
class ApplicationFactory
{
	/**
	 * Prevent object creation
	 */
	private function __construct()
	{
		//
	}

	/**
	 * The storage type our model uses for retrieving template data.
	 *
	 * @return object $storage_type Storage object
	 */
	private function _makeTemplateStorage($storage_type)
	{
		return new $storage_type();
	}
	
	/**
	 * Handles the creation of new model objects based upon the controller.
	 * 
	 * Before we create the model object, we create its dependencies. The model
	 * depends upon a storage object, so we create it and then pass it to the
	 * model constructor.
	 * 
	 * @param string $controller_name Allows us to make the correct model
	 * @param string $storage_type Type of storage object to make for model
	 * @return object model_name The model object for the controller
	 */
	private function _makeModel($controller_name, $storage_type)
	{
		$model_name		= $controller_name . 'Model';
		$storage_type	= strtolower($storage_type);
		
		$storage	= self::_makeTemplateStorage($storage_type);
		$log		= self::makeLogger();		
		
		return new $model_name($storage, $storage_type, $log);
	}
	
	/**
	 * Handles the creation of new view objects based upon the controller.
	 * 
	 * @param string $controller_name Allows us to make the correct view
	 * @return object view_name The view object for the controller
	 */
	private function _makeView($controller_name)
	{
		$view_name = $controller_name . 'View';

		return new $view_name();
	}
	
	/**
	 * Makes the log object our model has access to.
	 *
	 * @return object Log
	 */
	public static function makeLogger()
	{
		return new Log();
	}
	
	/**
	 * Handles the creation of the new controller object.
	 * 
	 * Before we create the controller object, we create its dependencies. The
	 * controller depends upon the view and the model, so we first create the
	 * appropriate counterparts to the controller and then pass them to the
	 * controller constructor.
	 * 
	 * @param string $controller_name To construct the correct controller
	 * @return object The controller with the name that matches the given URL.
	 */
	public static function makeController($controller_name)
	{
		$model	= self::_makeModel($controller_name, STORAGE_TYPE);
		$view	= self::_makeView($controller_name);
		
		return new $controller_name($model, $view);
	}
}
// End of ApplicationFactory Class

/* EOF lib/ApplicationFactory.php */