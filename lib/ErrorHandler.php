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
	 * @param type $log 
	 * @param type $email 
	 */
	public function __construct($log, $email)
	{
		$this->_log		= $log;
		$this->_email	= $email;
	}

	/**
	 * Allows us to log our fatal errors.
	 *
	 * @param string $msg Message to prepend to log message
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
	}
	
	/**
	 * Allows us to send an email notification upon fatal error.
	 *
	 * @param string $subject Subject line for email
	 * @param string $msg Message to prepend to email message
	 */
	private function _sendEmail($subject, $msg)
	{
		$email_message = $msg . '<br />';
		
		foreach (error_get_last() as $key => $value)
		{
			$email_message .= $key . ' => ' . $value . '<br />';
		}
		
		$this->_email->setEmailAddress(EMAIL_ADDRESS);
		$this->_email->setSubject($subject);
		$this->_email->setMessage($email_message);
		$this->_email->setReplyTo(EMAIL_ADDRESS);
		
		$this->_email->sendMessage(EMAIL_HEADERS);
	}
	
	/**
	 * We use this function to display a friendly page upon fatal error when we
	 * are hiding normal error reporting.
	 * 
	 * We look to see if constant is defined from the end of our script. If the
	 * constant is defined, the script executed successfully, so we do nothing.
	 * If it is not defined, we encountered a fatal error, so we log, email, and
	 * load our error page.
	 */
	public function showFatalErrorPage()
	{
		if ( ! defined('EXECUTION_SUCCESSFUL'))
		{
			$this->_createLog('Encountered fatal error: ');
			$this->_sendEmail('A Bright Concept Fatal Error', 'Encountered fatal error: ');
			
			header('Location:' . HTTP_ROOT_PATH . '/views/_template/error.html');
		}
	}
}
// End of ErrorHandler Class

/* EOF lib/ErrorHandler.php */