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
	 * 
	 * @return string
	 */
	public function buildErrorType($type)
	{
		return 'Oops! ' . $type . ':<br /><span>Page Not Found</span>';
	}
	
	/**
	 * Builds the error message for view output
	 * 
	 * @return string
	 */
	public function buildErrorMsg()
	{
		return 'The page you are looking for does not exist.';
	}
}
// End of ErrorView Class

/* EOF application/views/errorView.php */