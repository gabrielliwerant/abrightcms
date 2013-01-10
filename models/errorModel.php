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
 * ErrorModel Class
 * 
 * Allows us to manipulate persistent data for the view.
 * 
 * @subpackage models
 * @author Gabriel Liwerant
 * 
 * @uses Model
 */
class ErrorModel extends Model
{
	/**
	 * Call the parent constructor and pass it a database object.
	 * 
     * @param object $storage Data storage object
	 * @param string $storage_type The way data is stored and retrieved
	 * @param object $log Log object for errors, other
	 */
	public function __construct($storage_obj, $storage_type, $log, $db)
	{
		parent::__construct($storage_obj, $storage_type, $log, $db);
	}
}
// End of ErrorModel Class

/* EOF models/errorModel.php */