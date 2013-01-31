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
 * Model Class
 * 
 * We use this class to set our database connection for later use and to inject
 * dependencies as well as storing data from json files for later retrieval.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class Model
{
	/**
	 * Holds an instance of the storage object.
	 *
	 * @var object $_storage
	 */	
	protected $_storage;
	
	/**
	 * Holds an instance of the log object.
	 *
	 * @var object $_logger
	 */
	protected $_logger;
	
	/**
	 * Holds an instance of the key generator class.
	 *
	 * @var object $key_gen
	 */
	protected $_key_gen;
	
	/**
	 * Upon instantiation, we pass all the objects we want our model object to
	 * contain. We also load all data required according to storage type.
	 * 
	 * @param object $storage_obj Data storage object
	 * @param string $storage_type The way data is stored and retrieved
	 * @param object $logger_obj
	 */
	public function __construct($storage_obj, $storage_type, $logger_obj)
	{
		$this->_setStorageObject($storage_obj)->_setLogger($logger_obj);

		switch (strtolower($storage_type))
		{
			case 'json' :
				$file_arr = scandir(JSON_PATH);
				foreach ($file_arr as $file)
				{
					if (preg_match('/\.json/', $file))
					{
						$file_name = explode('.', $file);						
						$this->setDataFromStorage($file_name[0], $file_name[0]);
					}
				}
				break;
			case 'xml' :
				$file_arr = scandir(XML_PATH);		
				foreach ($file_arr as $file)
				{
					if (preg_match('/\.xml/', $file))
					{
						$file_name = explode('.', $file);
						$this->setDataFromStorage($file_name[0], $file_name[0]);
					}
				}
				break;
		}
	}
	
	/**
	 * Setter for storage object
	 *
	 * @param object $storage_obj
	 * 
	 * @return object Model 
	 */
	private function _setStorageObject($storage_obj)
	{
		$this->_storage	= $storage_obj;
		
		return $this;
	}

	/**
	 * Setter for Log object
	 *
	 * @param object $logger_obj
	 * 
	 * @return object Model 
	 */
	private function _setLogger($logger_obj)
	{
		$this->_logger = $logger_obj;
		
		return $this;
	}
	
	/**
	 * KeyGenerator factory
	 *
	 * @return object KeyGenerator
	 */
	private function _makeKeyGenerator()
	{
		return new KeyGenerator();
	}
	
	/**
	 * Builds log message from data and sends to log for writing.
	 *
	 * @param string $msg
	 * @param string $type
	 * @param string $file_name
	 * 
	 * @return boolean Success or failure of log writing
	 */
	protected function _writeLog($msg, $type, $file_name)
	{
		return $this->_logger->writeLogToFile($msg, $type, $file_name);
	}
	
	/**
	 * Create a log message from an array of data.
	 *
	 * @param array $data_to_log
	 * 
	 * @return string 
	 */
	protected function _buildLogMessageFromArray($data_to_log)
	{
		$log_msg = null;
		
		foreach ($data_to_log as $key => $value)
		{
			$log_msg .= $key . ' => ' . $value . ', ';
		}

		$log_msg = rtrim($log_msg, ', ');
		
		return $log_msg;
	}
	
	/**
	 * Adds a data file to the storage property.
	 *
	 * @param string $json_file Name of data file to set
	 * @param string $key Name of key to reference data file in array
	 * 
	 * @return object Model
	 */
	public function setDataFromStorage($data_file, $key)
	{
		$this->_storage->setFileAsArray($data_file, $key);
		
		return $this;
	}
	
	/**
	 * We grab the data from a data file, using our storage object.
	 *
	 * @param string $json_file Name of the file to load as view data
	 * 
	 * @return array Data from storage file
	 */
	public function getDataFromStorage($data_file)
	{		
		return $this->_storage->getFileAsArray($data_file);
	}
	
	/**
	 * Grabs all the data from our storage.
	 *
	 * @return array All data as array of arrays
	 */
	public function getAllDataFromStorage()
	{
		return $this->_storage->getAllDataAsArray();
	}
	
	/**
	 * KeyGenerator setter
	 *
	 * @return object Model
	 */
	public function setKeyGenerator()
	{
		$this->_key_gen = $this->_makeKeyGenerator();
		
		return $this;
	}
	
	/**
	 * Return a standard key from key generator object.
	 *
	 * @param integer $length Size of key
	 * @param array $type_arr Kind of key to generate
	 * 
	 * @return string 
	 */
	public function createStandardKeyFromKeyGenerator($length, $type_arr)
	{
		return $this->_key_gen->generateKeyFromStandard($length, $type_arr);
	}
	
	/**
	 * Destroy the data after it is no longer needed. We may also want to log it 
	 * from here in the future.
	 *
	 * @param string &$data Data to destroy
	 * 
	 * @return object Model
	 */
	public function destroyData(&$data)
	{
		$data = null;
		
		return $this;
	}
	
	/**
	 * Sanitize data
	 *
	 * @param string/array $data
	 * 
	 * @return string/array
	 */
	public function sanitizeData($data)
	{
		if (is_array($data))
		{
			foreach ($data as $key => $value)
			{
				$clean_data[$key] = strip_tags($value);
			}
		}
		else
		{
			$clean_data = strip_tags($data);
		}
		
		return $clean_data;
	}
	
	/**
	 * Take data from URL that was passed as serialized string through AJAX and
	 * make it into a properly-formatted POST array.
	 *
	 * @param string $url_data
	 * 
	 * @return array
	 */
	public function getDataAsPostArrayFromSerializedUrlString($url_data)
	{
		foreach($url_data as $value)
		{
			$get_arr			= explode('=', $value);
			$post[$get_arr[0]]	= $get_arr[1];
		}
		
		return $post;
	}
}
// End of Model Class

/* EOF lib/Model.php */