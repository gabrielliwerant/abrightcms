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
 * App Class
 * 
 * @subpackage controllers
 * @author Gabriel Liwerant
 * 
 * @uses Controller
 */
Class App extends Controller
{
	/**
	 * Construct the parent class.
	 * 
	 * @param object $view Pass the view we want to store in the controller
	 * @param object $model Pass the model we want to store in the controller
	 */
	public function __construct($view, $model)
	{
		parent::__construct($view, $model);
	}
	
	/**
	 * Loads the index page view.
	 * 
	 * We can set whatever values we want to use in the template here, or we can
	 * use the defaults in the base render method.
	 */
	public function index($page_name)
	{
		$this->render($page_name);
	}
}
// End of App Class

/* EOF app.php */