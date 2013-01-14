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
	 * @param object $model Pass the model we want to store in the controller
	 * @param object $view Pass the view we want to store in the controller
	 */
	public function __construct($model, $view)
	{
		parent::__construct($model, $view);
	}
	
	/**
	 * Loads the index page view.
	 * 
	 * We can set whatever values we want to use in the template here, or we can
	 * use the defaults in the base render method.
	 * 
	 * @param array $parameter_arr
	 */
	public function index($parameter_arr)
	{
		$error_header	= $parameter_arr[0];
		$error_msg		= $parameter_arr[1];
		
		$this->_view->setErrorType($error_header);
		$this->_view->setErrorMsg($error_msg);
		
		$page_name = 'error-404';
		
		$this->_view->page = $page_name;
		
		$this->render($page_name);
	}
}
// End of Error Class

/* EOF controllers/error.php */