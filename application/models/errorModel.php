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
 * ErrorModel Class
 * 
 * @subpackage models
 * @author Gabriel Liwerant
 * 
 * @uses TemplateModel
 */
class ErrorModel extends TemplateModel
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
// End of ErrorModel Class

/* EOF application/models/errorModel.php */