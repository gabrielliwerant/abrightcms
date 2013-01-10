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
 * AppView Class
 * 
 * @subpackage views
 * @author Gabriel Liwerant
 * 
 * @uses View
 */
class AppView extends View
{
	/**
	 * Construct the parent class.
	 */
	public function __construct()
	{
		parent::__construct();
	}
}
// End of AppView Class

/* EOF views/appView.php */