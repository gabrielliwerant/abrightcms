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
	 * Stores array of arrays for JSON files with their associated data.
	 *
	 * @var array $json
	 */
	public $json = array();
	
	/**
	 * Upon construction, store the default template JSON file in our JSON 
	 * property.
	 * 
	 * @param array $json_file_arr JSON files to store
	 */
	public function __construct($json_file_arr)
	{
		foreach($json_file_arr as $key => $json_file)
		{
			$this->setJsonFileAsArray($json_file, $key);
		}
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
				//throw exception
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
				//throw exception
			}
		}
	}
	
	/**
	 * Loads a JSON file and then stores the decoded data into an array.
	 * 
	 * @param string $file_name Is the name of the JSON file we want data from
	 * @param string $key Allows us to set a name for the JSON array
	 */
	public function setJsonFileAsArray($file_name, $key)
	{
		$json_encoded = file_get_contents(JSON_PATH . '/' . $file_name . '.json');
		
		$this->json[$key] = $this->getJsonDecode($json_encoded);
	}
	
	/**
	 * Returns a JSON file as an array from our property.
	 * 
	 * @param string $json_key Is the name of the JSON file
	 * @return array Gets us the specific array we want 
	 */
	public function getJsonFileAsArray($json_key)
	{
		return $this->json[$json_key];
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
			if (class_exists('MyException'))
			{
				throw new MyException('Could not convert string to boolean in ' . __CLASS__ . ' class');
			}
			else
			{
				throw new Exception('Could not convert string to boolean in ' . __CLASS__ . ' class');
			}
		}

		return $true_boolean;
	}
}
// End of Json Class

/* EOF lib/Json.php */