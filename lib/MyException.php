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
	 * Holds an instance of the log class for error logging
	 *
	 * @var object $_logger 
	 */
	private $_logger;
	
	/**
	 * Call the parent constructor when we throw a new exception.
	 *
	 * @param object $logger_obj
	 * @param string $msg Exception message
	 * @param integer $code Reference code for exception
	 * @param object $previous Previous exception, if one exists
	 */
	public function __construct($logger_obj, $msg = null, $code = null, $previous = null)
	{
		$this->_setLogger($logger_obj);
		
		if (PHP_VERSION < 5.3)
		{
			parent::__construct($msg, $code);
		}
		else
		{
			parent::__construct($msg, $code, $previous);
		}
	}
	
	/**
	 * Logger Setter
	 *
	 * @param object $logger_obj
	 * 
	 * @return object MyException 
	 */
	private function _setLogger($logger_obj)
	{
		$this->_logger = $logger_obj;
		
		return $this;
	}
	
	/**
	 * Create error logs for exceptions.
	 *
	 * @param object $log Log object
	 * @param object $exception Exception object to use for logging
	 * 
	 * @return object MyException
	 */
	private function _createLog($log, $exception)
	{
		$log_data['message']	= $exception->getMessage();
		$log_data['code']		= $exception->getCode();
		$log_data['file']		= $exception->getFile();
		$log_data['line']		= $exception->getLine();
		$log_data['stack_trace']= "\r\n" . $exception->getTraceAsString();

		$log_message = null;
		foreach ($log_data as $key => $value)
		{
			$log_message .= $key . ' => ' . $value . ', ';
		}

		$log_message = rtrim($log_message, ', ');

		$log->writeLogToFile($log_message, 'exception', 'exceptionLog');
		
		return $this;
	}
	
	/**
	 * Caught exceptions are handled here and logged to a file for reference.
	 */
	public function caughtException()
	{				
		if (IS_MODE_LOGGING)
		{
			$this->_createLog($this->_logger, $this);
		}
	
		$this->exception_msg = 'Caught ' . $this->getMessage() . '. Exception code: #' . $this->getCode();
		
		require_once TEMPLATE_PATH	. '/exception.php';
	}
	
	/**
	 * Uncaught exceptions are handled here.
	 *
	 * @param object $e Exception object to handle
	 */
	public function uncaughtException($e)
	{
		if (IS_MODE_LOGGING)
		{
			$this->_createLog($this->_logger, $e);
		}
		
		$this->exception_msg = 'Uncaught ' . $e->getMessage() . '. Exception code: #' . $e->getCode();
		
		require_once TEMPLATE_PATH	. '/exception.php';
	}
}
// End of MyException Class

/* EOF lib/MyException.php */