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
 * Json Class
 * 
 * Contains the methods and properties necessary to load JSON data into the 
 * program and then provide a means to access it.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class Json
{
	/**
	 * Error codes for Json class.
	 */
	const JSON_LAST_ERROR				= 1001;
	const COULD_NOT_CONVERT_TO_BOOELAN	= 1002;
	
	/**
	 * Stores array of arrays for JSON files with their associated data.
	 *
	 * @var array $_json
	 */
	private $_json = array();
	
	/**
	 * Nothing to see here...
	 */
	public function __construct()
	{
		//
	}
	
	/**
	 * Handles JSON decoding.
	 *
	 * @param string $json_encoded Encoded JSON contents
	 * @param boolean $make_assoc_arr Return as associative array or not
	 * @param integer $depth How many nested layers deep to search
	 * @return array/obj Decoded JSON contents in format chosen
	 */
	public function getJsonDecode(
		$json_encoded, 
		$make_assoc_arr = true, 
		$depth = 25
	)
	{
		if (PHP_VERSION < 5.3)
		{
			return json_decode($json_encoded, $make_assoc_arr);
		}
		else
		{
			$json_decode = json_decode($json_encoded, $make_assoc_arr, $depth);
			
			if (json_last_error() === JSON_ERROR_NONE)
			{
				return $json_decode;
			}
			else
			{
				throw make_exception_object('Json Exception (' . json_last_error() . ')', self::JSON_LAST_ERROR);
			}
		}
	}
	
	/**
	 * Handles JSON encoding.
	 *
	 * @param string $value Contents to be encoded as JSON
	 * @return string Encoded JSON contents
	 */
	public function getJsonEncode($value)
	{
		if (PHP_VERSION < 5.3)
		{
			return json_encode((string)$value);
		}
		else
		{
			$json_encode = json_encode((string)$value);
			
			if (json_last_error() === JSON_ERROR_NONE)
			{
				return $json_encode;
			}
			else
			{
				throw make_exception_object('Json Exception (' . json_last_error() . ')', self::JSON_LAST_ERROR);
			}
		}
	}
	
	/**
	 * Loads a JSON file and then stores the decoded data into an array.
	 * 
	 * @param string $file_name Is the name of the JSON file we want data from
	 * @param string $key Allows us to set a name for the JSON array
	 */
	public function setFileAsArray($file_name, $key)
	{
		$json_encoded = file_get_contents(JSON_PATH . '/' . $file_name . '.json');
		
		$this->_json[$key] = $this->getJsonDecode($json_encoded);
	}
	
	/**
	 * Returns a JSON file as an array from our property.
	 * 
	 * @param string $json_key Is the name of the JSON file
	 * @return array Gets us the specific array we want 
	 */
	public function getFileAsArray($json_key)
	{
		return $this->_json[$json_key];
	}
	
	/**
	 * Returns all JSON files as an array of arrays.
	 *
	 * @return array Entire array of arrays of JSON data
	 */
	public function getAllDataAsArray()
	{
		return $this->_json;
	}
	
	/**
	 * We sometimes need a true or false value passed with a string. We may 
	 * attempt to pass "true" and "false" and this function will convert them to 
	 * their intended boolean. Use with care.
	 *
	 * @param string $psuedo_boolean String we attempt to convert to boolean
	 * @return boolean Successfully converted boolean value
	 */
	public function getStringValueAsBoolean($psuedo_boolean)
	{       
		if ($psuedo_boolean === 'true')
		{
			$true_boolean = true;
		}
		elseif ($psuedo_boolean === 'false')
		{
			$true_boolean = false;
		}
		else
		{
			throw make_exception_object('Json Exception', self::COULD_NOT_CONVERT_TO_BOOELAN);
		}

		return $true_boolean;
	}
}
// End of Json Class

/* EOF lib/Json.php */