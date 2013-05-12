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
 * Error Class
 * 
 * Routing errors use this page controller.
 *
 * @subpackage controllers 
 * @author Gabriel Liwerant
 * 
 * @uses DefaultErrorPage
 */
class Error extends DefaultErrorPage implements PageControllerInterface
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
	 * Call any methods necessary to build out basic page elements and set them 
	 * as view properties for viewing.
	 * 
	 * @param array $data From storage to build out view properties
	 * @param string $this_class_name
	 * @param string|void $cache_buster Allows us to force re-caching
	 * 
	 * @return object Error Returned from parent method 
	 */
	protected function _pageBuilder($data, $this_class_name, $cache_buster = null)
	{
		$this
			->_setViewProperty('title_page', $data['template']['head']['title_page'][$this_class_name]['text']);
		
		return parent::_pageBuilder($data, $this_class_name, $cache_buster);
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
		$data = $this->_model->getAllDataFromStorage();		
		$this_class_name = strtolower(__CLASS__);
		
		switch (get_parent_class())
		{
			case 'DefaultPage':
				break;
			case 'DefaultBlogPage':
				break;
			case 'DefaultErrorPage':
				$data['error_header'] = $parameter_arr[0];
				break;
			default:
				break;
		}
		
		$cache_buster = $this->_cacheBuster(IS_MODE_CACHE_BUSTING, CACHE_BUSTING_VALUE);

		$this
			->_pageBuilder($data, $this_class_name, $cache_buster)
			->render($this_class_name);
	}
}
// End of Error Class

/* EOF application/controllers/error.php */