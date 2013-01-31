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
 * Contact Class
 * 
 * @subpackage controllers
 * @author Gabriel Liwerant
 * 
 * @uses Controller
 */
class Contact extends Controller
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
	 * @param string $cache_buster Allows us to force re-caching
	 * @return object App Returned from parent method
	 */
	protected function _pageBuilder($data, $cache_buster = null)
	{
		$this->_setHeadTitlePage($data['template']['head']['title_page'], strtolower(__CLASS__))
			->_setHeaderNav($data['header']['header']['header_nav'], $data['header']['header']['separator'])
			->_setLogoInAnchorTag('header_', $data['header']['header']['branding'])
			->_setSiteName($data['header']['header']['branding']['logo']['text'])
			->_setTagline($data['header']['header']['branding']['tagline'])
			->_setFooterNav($data['template']['footer']['footer_nav'], $data['template']['footer']['separator']);
		
		return parent::_pageBuilder($data['template'], $cache_buster);
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
		
		$this->_pageBuilder($data, $cache_buster)
			->render(strtolower(__CLASS__), $data['template'], $cache_buster);
	}
}
// End of Contact Class

/* EOF controllers/contact.php */