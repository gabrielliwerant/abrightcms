<?php if ( ! defined('DENY_ACCESS')) exit('403: No direct file access allowed');

/**
 * A Bright CMS
 * 
 * Open source, lightweight, web application framework and content management 
 * system in PHP.
 * 
 * @package A Bright CMS
 * @author Gabriel Liwerant
 */

/**
 * AppModel Class
 * 
 * @subpackage models
 * @author Gabriel Liwerant
 * 
 * @uses Model
 */
class AppModel extends Model
{
	/**
	 * Call the parent constructor and pass it objects.
	 * 
     * @param object $storage Data storage object
	 * @param string $storage_type The way data is stored and retrieved
	 * @param object $log Log object for errors, other
	 * @param object|void $db
	 */
	public function __construct($storage_obj, $storage_type, $log, $db = null)
	{
		parent::__construct($storage_obj, $storage_type, $log, $db);
	}
}
// End of appModel Class

/* EOF application/models/appModel.php */