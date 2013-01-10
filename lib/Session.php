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
 * We only want one session active at a time. We can also create session ids 
 * and destroy sessions.
 */
class Session
{
	/**
	 * Session objects without a started session are sad, so we start it with
	 * our constructor.
	 */
	public function __construct()
	{
		$this->startSession();
	}
	
	/**
	 * Begins a new session and then sets a value to inform us.
	 */
	public function startSession()
	{
		session_start();
		
		$this->set('is_session', true);
	}
	
	/**
	 * Allows us to set information in the $_SESSION[] super global array for
	 * session-persistent values and later retrieval.
	 */
	public function set(
		$key,
		$value
	)
	{
		$_SESSION[$key] = $value;
	}
	
	/**
	 * Allows us to retrieve any session values we've set.
	 * 
	 * @return
	 */
	public function get($key)
	{
		return $_SESSION[$key];
	}
	
	/**
	 * Defines a session id that we can use to identify a particular session
	 */	
	public function createSessionId()
	{
		return session_id();
	}
	
	/**
	 * Ends our session.
	 */
	public function destroySession()
	{
		session_destroy();
	}
	
	/**
     * Prevent the cloning of the object instance.
     */
    final private function __clone()
	{
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}
	
	/* public function __clone()
	{
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    } */
}
// End of Session class

/* EOF Session.php */