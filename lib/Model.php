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
	 * Holds an instance of the database class.
	 *
	 * @var object $db
	 */
	public $db;
	/**
	 * Holds an instance of the JSON class.
	 *
	 * @var object $json
	 */
	public $json;
	/**
	 * Holds an instance of the key generator class.
	 *
	 * @var object $key_gen
	 */
	public $key_gen;
	
	/**
	 * Upon instantiation, we pass all the objects we want our model object to
	 * contain. We also store the database table names.
	 * 
	 * @param object $db Database object to set in our model object
	 * @param object $json JSON object to set in our model object
	 */
	public function __construct($db, $json)
	{
		$this->db		= $db;
		$this->json		= $json;
		
		$this->db->setDatabaseTableNames(array(
			'role_type'			=> 'role_type',
			'flag_type'			=> 'flag_type',
			'user'				=> 'user',
			'user_setting'		=> 'user_setting',
			'group'				=> 'group',
			'project'			=> 'project',
			'project_comment'	=> 'project_comment',
			'list'				=> 'list',
			'list_comment'		=> 'list_comment',
			'item'				=> 'item',
			'item_comment'		=> 'item_comment',
			'item_status'		=> 'item_status',
			'status_type'		=> 'status_type'
			)
		);
	}
	
	/**
	 * Gather the data we need to build out the standard template.
	 * 
	 * We grab the data from a JSON file, using our JSON object.
	 *
	 * @param string $json_file Name of the JSON file to load as view data
	 * @return array JSON template data
	 */
	public function getTemplateData($json_file = 'default')
	{
		return $this->json->getJsonFileAsArray($json_file);
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
}
// End of Model Class

/* EOF lib/Model.php */