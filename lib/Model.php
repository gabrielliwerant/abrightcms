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
	 */
	public function destroyData(&$data)
	{
		$data = null;
	}
}
// End of Model Class

/* EOF lib/Model.php */