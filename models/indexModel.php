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
 * IndexModel Class
 * 
 * Allows us to manipulate persistent data for the view.
 * 
 * @subpackage models
 * @author Gabriel Liwerant
 * 
 * @uses Model
 */
class IndexModel extends Model
{
	/**
	 * Call the parent constructor and pass it objects.
	 * 
	 * @param object $db Database object to pass to the model constructor
     * @param object $json
	 */
	public function __construct($db, $json)
	{
		parent::__construct($db, $json);
	}
}
// End of IndexModel Class

/* EOF models/indexModel.php */