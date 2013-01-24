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
class Error extends Controller
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
	 * Set the view property for the error page type (header).
	 *
	 * @param string $error_header
	 * @return object Error 
	 */
	private function _setErrorType($error_header)
	{
		$this->_view->error_type = $this->_view->buildErrorType($error_header);
		
		return $this;
	}
	
	/**
	 * Set the view property for the error page message.
	 *
	 * @return object Error 
	 */
	private function _setErrorMsg()
	{
		$this->_view->error_msg = $this->_view->buildErrorMsg();
		
		return $this;
	}
	
	/**
	 * Call any methods necessary to build out basic page elements and set them 
	 * as view properties for viewing.
	 * 
	 * @param array $data From storage to build out view properties
	 * @param string $cache_buster Allows us to force re-caching
	 * @return object Error Returned from parent method 
	 */
	protected function _pageBuilder($data, $cache_buster)
	{
		$this->_setHeaderNav($data['header']['header']['header_nav'], $data['header']['header']['separator'])
			->_setLogoInAnchorTag('header_', $data['header']['header']['branding'])
			->_setSiteName($data['header']['header']['branding']['logo']['text'])
			->_setTagline($data['header']['header']['branding']['tagline'])
			->_setFooterNav($data['template']['footer']['footer_nav'], $data['template']['footer']['separator'])
			->_setErrorType($data['error_header'])
			->_setErrorMsg();
		
		return parent::_pageBuilder($data['template'], $cache_buster);
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
		$data					= $this->_model->getAllDataFromStorage();
		$data['error_header']	= $parameter_arr[0];
		$cache_buster			= $this->_cacheBuster(IS_MODE_CACHE_BUSTING, CACHE_BUSTING_VALUE);
		
		$this->_pageBuilder($data, $cache_buster)
			->render(strtolower(__CLASS__), $data['template'], $cache_buster);
	}
}
// End of Error Class

/* EOF controllers/error.php */