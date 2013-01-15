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
	 * @var object $storage
	 */	
	public $storage;
	
	/**
	 * Holds an instance of the log object.
	 *
	 * @var object $log
	 */
	public $log;
	
	/**
	 * Holds an instance of the key generator class.
	 *
	 * @var object $key_gen
	 */
	public $key_gen;
	
	/**
	 * Upon instantiation, we pass all the objects we want our model object to
	 * contain. We also load all data required according to storage type.
	 * 
	 * @param object $storage_obj Data storage object
	 * @param string $storage_type The way data is stored and retrieved
	 */
	public function __construct($storage_obj, $storage_type, $log_obj)
	{
		$this->storage	= $storage_obj;
		$this->log		= $log_obj;		

		switch ($storage_type)
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
	 * Adds a data file to the storage property.
	 *
	 * @param string $json_file Name of data file to set
	 * @param string $key Name of key to reference data file in array
	 */
	public function setDataFromStorage($data_file, $key)
	{
		$this->storage->setFileAsArray($data_file, $key);
	}
	
	/**
	 * We grab the data from a data file, using our storage object.
	 *
	 * @param string $json_file Name of the file to load as view data
	 * @return array Data from storage file
	 */
	public function getDataFromStorage($data_file)
	{		
		return $this->storage->getFileAsArray($data_file);
	}
	
	/**
	 * Grabs all the data from our storage.
	 *
	 * @return array All data as array of arrays
	 */
	public function getAllDataFromStorage()
	{
		return $this->storage->getAllDataAsArray();
	}
	
	/**
	 * Sets the key generator property with the appropriate object.
	 *
	 * @param object $key_gen Key Generator object to set
	 */
	public function setKeyGenerator($key_gen)
	{
		$this->key_gen = $key_gen;
	}
	
	/**
	 * Destroy the data after it is no longer needed. We may also want to log it 
	 * in the future.
	 *
	 * @param string &$data Data to destroy, passed by reference
	 */
	public function destroyData(&$data)
	{
		$data = null;
	}
}
// End of Model Class

/* EOF lib/Model.php */