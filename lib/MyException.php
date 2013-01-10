<?php

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
 * MyException Class
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 * 
 * @uses Exception
 */
class MyException extends Exception
{
	/**
	 * Call the parent constructor when we throw a new exception.
	 *
	 * @param string $msg Exception message
	 * @param integer $code Reference code for exception
	 * @param object $previous Previous exception, if one exists
	 */
	public function __construct($msg = null, $code = null, $previous = null)
	{
		parent::__construct($msg, $code, $previous);
	}
	
	/**
	 * Caught exceptions are handled here and logged to a file for reference.
	 *
	 * @param object $log Log object for logging our exception
	 */
	public function caughtException($log)
	{
		echo 'Caught Exception: ' . $this->getMessage();
		
		if (IS_MODE_LOGGING)
		{
			$log->writeLogToFile($this->getMessage(), 'error', 'errorLog');
		}
	}
	
	/**
	 * Uncaught exceptions are handled here.
	 *
	 * @param object $e Exception object to handle
	 */
	public function uncaughtException($e)
	{
		echo 'Uncaught exception: ' . $e->getMessage();
		
		// @todo inject log object so we can log these too
	}
}
// End of MyException Class

/* EOF lib/MyException.php */