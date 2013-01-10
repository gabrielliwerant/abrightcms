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
	 * Sets the error type for view output.
	 * 
	 * @param string $type Error type
	 */
	public function setErrorType($type)
	{
		$this->error_type = $type;
	}
	
	/**
	 * Sets the error message for view output
	 * 
	 * @param string $msg Error message
	 */
	public function setErrorMsg($msg)
	{
		$this->error_msg = $msg;
	}
}
// End of ErrorView Class

/* EOF views/errorView.php */