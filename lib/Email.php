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
 * Email Class
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class Email
{
	/**
	 * Stores the email address to send the email to
	 *
	 * @var string $_email
	 */
	private $_email;
	
	/**
	 * Subject line for email
	 *
	 * @var string $_subject
	 */
	private $_subject;
	
	/**
	 * Email message
	 *
	 * @var string $_message
	 */
	private $_message;
	
	/**
	 * Reply-To header
	 *
	 * @var string $_reply_to
	 */
	private $_reply_to;
	
	/**
	 * Nothing to see here...
	 */
	public function __construct()
	{
		//
	}
	
	/**
	 * Set email property
	 *
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->_email = $email;
	}
	
	/**
	 * Set subject property
	 *
	 * @param string $subject 
	 */
	public function setSubject($subject)
	{
		$this->_subject = $subject;
	}
	
	/**
	 * Set message property
	 *
	 * @param string $message 
	 */
	public function setMessage($message)
	{
		$this->_message = $message;
	}
	
	/**
	 * Set reply to property
	 *
	 * @param string $reply_to 
	 */
	public function setReplyTo($reply_to)
	{
		$this->_reply_to = $reply_to;
	}
	
	/**
	 * Sends an email with the properties and any headers and then return a
	 * boolean to indicate success or failure.
	 *
	 * @return boolean 
	 */
	public function sendMessage($email_headers)
	{
		$from		= 'From: ' . $this->_reply_to . "\r\n";
		$reply_to	= 'Reply-To: ' . $this->_reply_to . "\r\n";
		
		return mail(
			$this->_email, 
			$this->_subject, 
			$this->_message, 
			$email_headers . $from . $reply_to
		);
	}
}
// End of Email Class

/* EOF lib/Email.php */