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
 * PageViewInterface Interface
 * 
 * Forces essential methods onto page views.
 * 
 * @subpackage views/includes
 * @author Gabriel Liwerant
 */
interface PageViewInterface
{
	/**
	 * Page views must construct parent view.
	 */
	public function __construct();
}
// End of PageViewInterface Interface

/* EOF application/views/_includes/pageViewInterface.php */