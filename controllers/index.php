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
 * Index Class
 * 
 * The index controller inherits from the template and can override methods and 
 * set customer values for properties as desired.
 * 
 * @subpackage controllers
 * @author Gabriel Liwerant
 * 
 * @uses Controller
 */
Class Index extends Controller
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
	 * @param array $parameter_arr
	 */
	public function index($parameter_arr)
	{
		// Retrieve all JSON data into variables with the name of the file
		$json_data = $this->_model->getAllDataFromStorage();
		foreach ($json_data as $file_name => $content)
		{
			$$file_name = $content;
		}

		// Build page-specific elements
		$this->_setHeaderNav($header['header']['header_nav'], $header['header']['separator']);
		$this->_setFooterNav($template['footer']['footer_nav'], $template['footer']['separator']);
		
		$page_name = 'index';
		
		$this->_view->page = $page_name;
		
		$this->render($page_name);
	}
}
// End of Index Class

/* EOF index.php */