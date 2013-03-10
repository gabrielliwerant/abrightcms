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
 * Example Class
 * 
 * An simple implementation of a typical page controller.
 * 
 * @subpackage controllers
 * @author Gabriel Liwerant
 * 
 * @uses DefaultPage
 */
class Example extends DefaultPage implements PageControllerInterface
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
	 * Call any methods necessary to build out page-specific elements and set
	 * them as view properties for viewing.
	 *
	 * @param array $data From storage to build out page views
	 * @param string|void $cache_buster Allows us to force re-caching
	 * 
	 * @return object App Returned from parent method
	 */
	protected function _pageBuilder($data, $cache_buster = null)
	{
		$this
			->_setViewProperty('title_page', $data['template']['head']['title_page'][strtolower(__CLASS__)]['text'])
			->_setViewProperty('example_content', $data['example']['content']);
		
		return parent::_pageBuilder($data, $cache_buster);
	}
	
	/**
	 * Loads the index page view.
	 * 
	 * We retrieve data and call the page builder here, which should set up 
	 * everything we need to display this page with the parent render method.
	 * 
	 * @param array $parameter_arr
	 */
	public function index($parameter_arr)
	{
		$data			= $this->_model->getAllDataFromStorage();
		$cache_buster	= $this->_cacheBuster(IS_MODE_CACHE_BUSTING, CACHE_BUSTING_VALUE);
		
		$this->_pageBuilder($data, $cache_buster)->render(strtolower(__CLASS__));
	}
}
// End of Example Class

/* EOF application/controllers/example.php */