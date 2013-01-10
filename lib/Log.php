<?php

/**
 * TaskVolt
 * 
 * Project management, todo list, collaboration, and social web application tool
 * for consumers.
 * 
 * @package TaskVolt
 * @author Gabriel Liwerant
 * @link http://taskvolt.com
 */

/**
 * Log Class
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class Log
{
	/**
	 * Nothing to see here...
	 */
	public function __construct()
	{
		//
	}
	
	/**
	 * Opens a file for logging and then writes a message to it.
	 *
	 * @param string $msg Message to write to log file
	 * @param string $type Type of message logged
	 * @param string $file_name Name of file to write log to
	 * @return boolean Return true or false to indicate success of logging
	 */
	public function writeLogToFile($msg, $type, $file_name)
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
}
// End of Log Class

/* EOF lib/Log.php */