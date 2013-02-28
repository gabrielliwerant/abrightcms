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
 * DefaultPage Class
 * 
 * Creates default page so that child classes do not need to duplicate code.
 * Contains no index method because we are not meant to call this class directly.
 * 
 * @subpackage controllers/includes
 * @author Gabriel Liwerant
 * 
 * @uses Controller
 */
class DefaultPage extends Controller
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
	 * @return object Index Returned from parent method
	 */
	protected function _pageBuilder($data, $cache_buster = null)
	{
		$this
			->_setNav('header_nav', $data['header']['header']['header_nav'], $data['header']['header']['separator'])
			->_setLogo('header_logo', $data['header']['header']['branding']['logo'])
			->_setViewProperty('site_name', $data['header']['header']['branding']['logo']['text'])
			->_setViewProperty('tagline', $data['header']['header']['branding']['tagline'])
			->_setFinePrint($data['template']['footer']['fine_print'], $data['template']['footer']['separator'])
			->_setNav('footer_nav', $data['template']['footer']['footer_nav'], $data['template']['footer']['separator']);
		
		return parent::_pageBuilder($data['template'], $cache_buster);
	}
}
// End of DefaultPage Class

/* EOF application/controllers/includes/defaultPage.php */