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
 * Error Class
 * 
 * The error controller allows us to inherit from the template, override 
 * methods, and set customer values for properties as desired.
 *
 * @subpackage controllers 
 * @author Gabriel Liwerant
 * 
 * @uses Controller
 */
Class Error extends Controller
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
	 * 
	 * @param string array $parameter_arr Contains the needed arguments
	 */
	public function index($parameter_arr)
	{
		$page_name		= $parameter_arr[0];
		$error_header	= $parameter_arr[1];
		$error_msg		= $parameter_arr[2];
		
		$this->_view->setErrorType($error_header);
		$this->_view->setErrorMsg($error_msg);
		
		$this->render($page_name);
	}
}
// End of Error Class

/* EOF controllers/error.php */