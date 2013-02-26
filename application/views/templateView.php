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
 * TemplateView Class
 * 
 * Use this to provide child classes with shared page view methods.
 * 
 * @subpackage views/includes
 * @author Gabriel Liwerant
 * 
 * @uses View
 */
class TemplateView extends View
{
	/**
	 * Construct the parent class.
	 */
	public function __construct()
	{
		parent::__construct();
	}
}
// End of TemplateView Class

/* EOF application/views/includes/templateView.php */