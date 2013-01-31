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
 * EmailMock Class
 * 
 * @subpackage dev/lib
 * @author Gabriel Liwerant
 */
class EmailMock extends Email
{
	/**
	 * Construct the parent.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * It is here that we mock a response from the actual mail function for test
	 * purposes.
	 *
	 * @return boolean 
	 */
	public function sendMessage($email_headers)
	{
		return true;
	}
}

// End of EmailMock Class

/* EOF dev/lib/EmailMock.php */