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
 * ErrorView Class
 * 
 * Allows us to create dynamic display elements.
 * 
 * @subpackage views
 * @author Gabriel Liwerant
 * 
 * @uses View
 */
class ErrorView extends View
{
	/**
	 * Construct the parent class.
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Builds the error type for view output.
	 * 
	 * @param string $type Error type
	 * @return string
	 */
	public function buildErrorType($type)
	{
		return 'Oops! ' . $type . ':<br /><span>Page Not Found</span>';
	}
	
	/**
	 * Builds the error message for view output
	 * 
	 * @param string $msg Error message
	 * @return string
	 */
	public function buildErrorMsg($msg)
	{
		return $msg;
	}
}
// End of ErrorView Class

/* EOF views/errorView.php */