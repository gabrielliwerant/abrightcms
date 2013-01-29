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
 * Log Class
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class Logger
{
	/**
	 * Property for whether or not we are in log mode
	 *
	 * @var boolean $_is_mode_logging
	 */
	private $_is_mode_logging;
	
	/**
	 * Upon contruction, set whether or not we are in logging mode.
	 *
	 * @param boolean $is_mode_logging 
	 */
	public function __construct($is_mode_logging = true)
	{
		$this->_setIsModeLogging($is_mode_logging);
	}
	
	/**
	 * Setter for is mode logging property
	 *
	 * @param boolean $is_mode_logging
	 * 
	 * @return object Logger 
	 */
	private function _setIsModeLogging($is_mode_logging)
	{
		$this->_is_mode_logging = $is_mode_logging;
		
		return $this;
	}
	
	/**
	 * Opens a file for logging and then writes a message to it.
	 *
	 * @param string $msg Message to write to log file
	 * @param string $type Type of message logged
	 * @param string $file_name Name of file to write log to
	 * 
	 * @return boolean Return true or false to indicate success of logging
	 */
	public function writeLogToFile($msg, $type, $file_name)
	{
		if ($this->_is_mode_logging)
		{
			$file_path = LOGS_PATH . '/' . $file_name . '.log';

			if ( ! $fh = @fopen($file_path, 'ab'))
			{
				return false;
			}
			else
			{
				$log_msg = '[' . date('m/d/Y h:i:s', time()) . '] ' . '[' . $type . '] ' . $msg . "\n";

				flock($fh, LOCK_EX);
				fwrite($fh, $log_msg);
				flock($fh, LOCK_UN);
				fclose($fh);

				@chmod($file_path, 0666);

				return true;
			}
		}
		else
		{
			return false;
		}
	}
}
// End of Log Class

/* EOF lib/Log.php */