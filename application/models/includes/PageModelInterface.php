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
 * PageModelInterface Interface
 * 
 * Forces essential methods onto page controllers.
 * 
 * @subpackage models/includes
 * @author Gabriel Liwerant
 */
interface PageModelInterface
{
	/**
	 * Page models must construct parent model with the following values.
	 */
	public function __construct($storage_obj, $storage_type, $log, $db = null);
}
// End of PageModelInterface Interface

/* EOF application/models/includes/pageModelInterface.php */