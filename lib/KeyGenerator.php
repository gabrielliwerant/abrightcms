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
 * KeyGenerator Class
 * 
 * Houses methods to generate key values.
 * 
 * We can generate a key from some standard key strings stored in a property or
 * we can generate a key from a passed key string argument.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class KeyGenerator
{
	/**
	 * Standard strings for use in composing a new key.
	 *
	 * @var array $_standard_key_type 
	 */
	private $_standard_key_type = array(
		'digital'		=> '0123456789',
		'alpha_lower'	=> 'abcdefghijklmnopqrstuvwxyz',
		'alpha_upper'	=> 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
		'symbol'		=> '~!@#$%^&*()_-+=|{[}]:;<,>.?'
	);
	
	/**
	 * Nothing to see here...
	 */
	public function __construct()
	{
		//
	}
	
	/**
	 * Generates a random key.
	 * 
	 * We can choose the size of the generated key, as well as what string 
	 * components we want to compose it.
	 * 
	 * @param integer $size Length of the key to generate
	 * @param string $generator_string Values to use in composing the key
	 * @return string Generated key
	 */
	private function _generateKey($size, $generator_string)
	{
        $key = null;		

		if (is_int($size))
		{		
			// Choose a random position in the generator string and build with 
			// that single character, repeating until we reach the maximum size.
			for ($i = 0; $i <= $size; $i++)
			{
				$key .= substr(
					$generator_string, 
					mt_rand(1, strlen($generator_string)), 
					1
				);
			}

			return $key;
		}
		else
		{
			throw new MyException('Expected Integer for Size of Generated Key.');
		}
	}
	
	/**
	 * Gets the key type from our array of standard key strings.
	 *
	 * @param string $type Array index to search for in standard key types
	 * @return string Generator string for key making
	 */
	private function _getStandardKeyType($type)
	{
		if (array_key_exists($type, $this->_standard_key_type))
		{
			$generator_string = $this->_standard_key_type[$type];
		}
		else
		{
			/* throw error incorrect type for standard key generation */
		}
		
		return $generator_string;
	}
	
	/**
	 * Composes a string to use in generating the key from our standard strings.
	 *
	 * @param integer $size Length of the key to generate
	 * @param array $type_arr Array indexes to use in composing the key
	 * @return string Generated key
	 */
	public function generateKeyFromStandard($size, $type_arr = array(
		'digital', 
		'alpha_lower', 
		'alpha_upper', 
		'symbol'
		)
	)
	{
		$generator_string = null;
		
		if (is_array($type_arr))
		{
			foreach ($type_arr as $type)
			{
				$generator_string .= $this->_getStandardKeyType($type);
			}
		}
		else
		{
			$generator_string = $this->_getStandardKeyType($type);
		}
		
		return $this->_generateKey($size, $generator_string);
	}
	
	/**
	 * Sends a user-entered string to compose a key.
	 *
	 * @param integer $size Length of the key to generate
	 * @param string $key_string Values to use in composing the key
	 * @return string Generated key
	 */
	public function generateKeyFromArgument($size, $key_string)
	{
		if (is_string($key_string))
		{
			$generator_string = $key_string;
			
			return $this->_generateKey($size, $generator_string);
		}
		else
		{
			throw new MyException('Expected String Key Generation.');
		}
	}
}
// End of KeyGenerator Class

/* EOF lib/KeyGenerator.php */