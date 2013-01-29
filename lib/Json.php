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
	 * Error codes for Json
	 */
	const JSON_LAST_ERROR_DECODE		= 1001;
	const JSON_LAST_ERROR_ENCODE		= 1002;
	const COULD_NOT_CONVERT_TO_BOOELAN	= 1003;
	
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
	 * 
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
				switch (json_last_error())
				{
					case JSON_ERROR_NONE:
						$json_err = 'No errors';
						break;
					case JSON_ERROR_DEPTH:
						$json_err = 'Maximum stack depth exceeded';
						break;
					case JSON_ERROR_STATE_MISMATCH:
						$json_err = 'Underflow or the modes mismatch';
						break;
					case JSON_ERROR_CTRL_CHAR:
						$json_err = 'Unexpected control character found';
						break;
					case JSON_ERROR_SYNTAX:
						$json_err = 'Syntax error, malformed JSON';
						break;
					case JSON_ERROR_UTF8:
						$json_err = 'Malformed UTF-8 characters, possibly incorrectly encoded';
						break;
					default:
						$json_err = 'Unknown error';
						break;
				}
				
				throw ApplicationFactory::makeException('Json Exception (' . $json_err . ')', self::JSON_LAST_ERROR_DECODE);
				//throw new Exception('Json Exception (' . $json_err . ')', self::JSON_LAST_ERROR_DECODE);
			}
		}
	}
	
	/**
	 * Handles JSON encoding.
	 *
	 * @param string, array, integer $value Contents to be encoded as JSON
	 * 
	 * @return string Encoded JSON contents
	 */
	public function getJsonEncode($value)
	{
		if (PHP_VERSION < 5.3)
		{
			return json_encode($value);
		}
		else
		{
			$json_encode = json_encode($value);
			
			$error_last = json_last_error();
			
			if ($error_last === JSON_ERROR_NONE)
			{
				return $json_encode;
			}
			else
			{
				switch (json_last_error())
				{
					case JSON_ERROR_NONE:
						$json_err = 'No errors';
						break;
					case JSON_ERROR_DEPTH:
						$json_err = 'Maximum stack depth exceeded';
						break;
					case JSON_ERROR_STATE_MISMATCH:
						$json_err = 'Underflow or the modes mismatch';
						break;
					case JSON_ERROR_CTRL_CHAR:
						$json_err = 'Unexpected control character found';
						break;
					case JSON_ERROR_SYNTAX:
						$json_err = 'Syntax error, malformed JSON';
						break;
					case JSON_ERROR_UTF8:
						$json_err = 'Malformed UTF-8 characters, possibly incorrectly encoded';
						break;
					default:
						$json_err = 'Unknown error';
						break;
				}
				
				throw ApplicationFactory::makeException('Json Exception (' . $json_err . ')', self::JSON_LAST_ERROR_ENCODE);
				//throw new Exception('Json Exception (' . $json_err . ')', self::JSON_LAST_ERROR_ENCODE);
			}
		}
	}
	
	/**
	 * Loads a JSON file and then stores the decoded data into an array.
	 * 
	 * @param string $file_name Is the name of the JSON file we want data from
	 * @param string $key Allows us to set a name for the JSON array
	 * 
	 * @return object Json
	 */
	public function setFileAsArray($file_name, $key)
	{
		$json_encoded = file_get_contents(JSON_PATH . '/' . $file_name . '.json');
		
		$this->_json[$key] = $this->getJsonDecode($json_encoded);
		
		return $this;
	}
	
	/**
	 * Returns a JSON file as an array from our property.
	 * 
	 * @param string $json_key Is the name of the JSON file
	 * 
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
	 * 
	 * @return boolean Successfully converted boolean value
	 */
	public function getStringValueAsBoolean($psuedo_boolean)
	{       
		if ($psuedo_boolean === 'true')
		{
			$real_boolean = true;
		}
		elseif ($psuedo_boolean === 'false')
		{
			$real_boolean = false;
		}
		else
		{
			throw ApplicationFactory::makeException('Json Exception', self::COULD_NOT_CONVERT_TO_BOOELAN);
			//throw new Exception('Json Exception', self::COULD_NOT_CONVERT_TO_BOOELAN);
		}

		return $real_boolean;
	}
}
// End of Json Class

/* EOF lib/Json.php */