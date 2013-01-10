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
	 * @param object $db Database object to pass to the model constructor
	 * @param object key_gen Key gen object to pass to the model constructor
	 */
	public function __construct($db, $key_gen)
	{
		parent::__construct($db, $key_gen);
	}
}
// End of ErrorModel Class

/* EOF models/errorModel.php */