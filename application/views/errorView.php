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
 * ErrorView Class
 * 
 * @subpackage views
 * @author Gabriel Liwerant
 * 
 * @uses DefaultErrorPageView
 */
class ErrorView extends DefaultErrorPageView implements PageViewInterface
{
	/**
	 * Construct the parent class.
	 */
	public function __construct()
	{
		parent::__construct();
	}
}
// End of ErrorView Class

/* EOF application/views/errorView.php */