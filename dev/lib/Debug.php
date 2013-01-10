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
 * Debug Class
 * 
 * Enable easy debugging output as a static class. We don't want this active in
 * production.
 * 
 * @subpackage dev/lib
 * @author Gabriel Liwerant
 */
class Debug
{
	/**
	 * Debug is a static class, so lets leave the constructor empty.
	 */
	private function __construct()
	{
		//
	}

	/**
	 * Use this method to display values for debugging purposes.
	 * 
	 * Use <pre> tags to create a readable display for our values. We can choose
	 * how we display those values and whether or not to exit immediately 
	 * afterwards to prevent continued program execution based on our arguments.
	 * 
	 * @param any $value Our display value
	 * @param boolean $is_arr Determines how we display the value
	 * @param boolean $is_exit Determines whether or not we halt the program
	 */
	private static function _toDisplay($value, $is_arr = true, $is_exit = true)
	{
		if (IS_MODE_DEBUG)
		{
			echo 'Output:';
			echo '<br />';
			echo '<pre>';
			
			$is_arr ? print_r($value) : var_dump($value);
			
			echo '</pre>';
			echo '<br />';
		
			$is_exit ? exit : false;
		}
		else
		{
			echo 'Cannot view: Debug mode is off.';
		}
	}
	
	/**
	 * Send arrays to display for debugging using print_r.
	 * 
	 * @param array $arr Array value to display
	 * @param boolean $is_exit Determines whether or not we halt the program
	 */
	public static function printArray($arr, $is_exit = true)
	{
		self::_toDisplay($arr, true, $is_exit);
	}
	
	/**
	 * Send values to display for debugging using var_dump.
	 * 
	 * @param array $value Value to display
	 * @param boolean $is_exit Determines whether or not we halt the program
	 */
	public static function varDump($value, $is_exit = true)
	{
		self::_toDisplay($value, false, $is_exit);
	}
	
	/**
	 * Send a backtrace to display for debugging.
	 *
	 * @param boolean $is_exit Determines whether or not we halt the program
	 */
	public static function stackTrace($is_exit = true)
	{
		$trace = debug_backtrace();
		
		self::_toDisplay($trace, true, $is_exit);
	}
}
// End of Debug Class

/* EOF dev/lib/Debug.php */