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
 * PageControllerInterface Interface
 * 
 * Forces essential methods onto page controllers.
 * 
 * @subpackage controllers/includes
 * @author Gabriel Liwerant
 */
interface PageControllerInterface
{
	/**
	 * Page controllers must construct a model and view.
	 */
	public function __construct($model, $view);
	
	/**
	 * Used to load a page controller from front controller.
	 */
	public function index($parameter_arr);
}
// End of PageControllerInterface Interface

/* EOF application/controllers/includes/pageControllerInterface.php */