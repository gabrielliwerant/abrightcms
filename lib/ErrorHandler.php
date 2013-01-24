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
 * ErrorHandler Class
 * 
 * This class allows us to report errors, record errors, and send users to a 
 * friendly error page. Intended for use with register_shutdown_function.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class ErrorHandler
{
	/**
	 * Holds an instance of the log class for error logging
	 *
	 * @var object $_log 
	 */
	private $_log;
	
	/**
	 * Stores an email object
	 *
	 * @var object $_email
	 */
	private $_email;
	
	/**
	 * Upon construction, pass in dependencies
	 *
	 * @param object $log 
	 * @param object $email 
	 */
	public function __construct($log, $email)
	{
		$this->_setLog($log)->_setEmail($email);
	}

	/**
	 * Setter for log
	 *
	 * @param object $log
	 * 
	 * @return object ErrorHandler 
	 */
	private function _setLog($log)
	{
		$this->_log = $log;
		
		return $this;
	}
	
	/**
	 * Setter for email
	 *
	 * @param object $email
	 * 
	 * @return object ErrorHandler 
	 */
	private function _setEmail($email)
	{
		$this->_email = $email;
		
		return $this;
	}
	
	/**
	 * Allows us to log our fatal errors.
	 *
	 * @param string $msg Message to prepend to log message
	 * 
	 * @return object ErrorHandler
	 */
	private function _createLog($msg)
	{
		$log_message = $msg;
		
		foreach (error_get_last() as $key => $value)
		{
			$log_message .= $key . ' => ' . $value . ', ';
		}
		
		$log_message = rtrim($log_message, ', ');
		
		$this->_log->writeLogToFile($log_message, 'error', 'errorLog');
		
		return $this;
	}
	
	/**
	 * Allows us to send an email notification upon fatal error.
	 *
	 * @param string $subject Subject line for email
	 * @param string $msg Message to prepend to email message
	 * 
	 * @return object ErrorHandler
	 */
	private function _sendEmail($subject, $msg)
	{
		$email_message = $msg . '<br />';
		
		foreach (error_get_last() as $key => $value)
		{
			$email_message .= $key . ' => ' . $value . '<br />';
		}
		
		$this->_email
			->setEmailAddress(EMAIL_ADDRESS)
			->setSubject($subject)
			->setMessage($email_message)
			->setReplyTo(EMAIL_ADDRESS)			
			->sendMessage(EMAIL_HEADERS);

		return $this;
	}
	
	/**
	 * Display a friendly page upon fatal error.
	 * 
	 * Useful when we are hiding normal error reporting. If we have an error, we 
	 * log it, email it, and load our error page.
	 */
	public function showFatalErrorPage()
	{
		$error_last = error_get_last();
		
		if ( ! empty($error_last) )
		{
			$this->_createLog('Encountered fatal error: ')
				->_sendEmail('A Bright CMS Fatal Error', 'Encountered fatal error: ');
			
			header('Location:' . ERROR_HANDLER_PAGE_PATH);
		}
	}
}
// End of ErrorHandler Class

/* EOF lib/ErrorHandler.php */