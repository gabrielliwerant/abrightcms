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
 * DefaultErrorPage Class
 * 
 * Creates default page so that child classes do not need to duplicate code.
 * Contains no index method because we are not meant to call this class directly.
 * 
 * @subpackage controllers/includes
 * @author Gabriel Liwerant
 * 
 * @uses Controller
 */
class DefaultErrorPage extends Controller
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
	 * 
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
	 * Call any methods necessary to build out page-specific elements and set
	 * them as view properties for viewing.
	 *
	 * @param array $data From storage to build out page views
	 * @param string $child_class_name
	 * @param string|void $cache_buster Allows us to force re-caching
	 * 
	 * @return object Index Returned from parent method
	 */
	protected function _pageBuilder($data, $child_class_name, $cache_buster = null)
	{
		$this
			->_setHeadIncludesLink($data['template']['head']['head_includes']['links'], $cache_buster)
			->_setNav('header_nav', $data['header']['header']['header_nav'], $data['header']['header']['separator'])
			->_setLogo('header_logo', $data['header']['header']['branding']['logo'])
			->_setViewProperty('site_name', $data['header']['header']['branding']['logo']['text'])
			->_setViewProperty('tagline', $data['header']['header']['branding']['tagline'])
			->_setFinePrint($data['template']['footer']['fine_print'], $data['template']['footer']['separator'])
			->_setNav('footer_nav', $data['template']['footer']['footer_nav'], $data['template']['footer']['separator'])
			->_setErrorType($data['error_header'])
			->_setErrorMsg();;
		
		return parent::_pageBuilder($data['template'], $child_class_name, $cache_buster);
	}
}
// End of DefaultErrorPage Class

/* EOF application/controllers/includes/DefaultErrorPage.php */