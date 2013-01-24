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
	 * @var string $_email_address
	 */
	private $_email_address;
	
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
	 * Set email address property
	 *
	 * @param string $email_address
	 * 
	 * @return object Email
	 */
	public function setEmailAddress($email_address)
	{
		$this->_email_address = $email_address;
		
		return $this;
	}
	
	/**
	 * Set subject property
	 *
	 * @param string $subject 
	 * 
	 * @return object Email
	 */
	public function setSubject($subject)
	{
		$this->_subject = $subject;
		
		return $this;
	}
	
	/**
	 * Set message property
	 *
	 * @param string $message 
	 * 
	 * @return object Email
	 */
	public function setMessage($message)
	{
		$this->_message = $message;
		
		return $this;
	}
	
	/**
	 * Set reply to property
	 *
	 * @param string $reply_to 
	 * 
	 * @return object Email
	 */
	public function setReplyTo($reply_to)
	{
		$this->_reply_to = $reply_to;
		
		return $this;
	}
	
	/**
	 * Sends an email with the properties and any headers which then returns a
	 * boolean to indicate success or failure.
	 *
	 * @return boolean 
	 */
	public function sendMessage($email_headers)
	{
		$from		= 'From: ' . $this->_reply_to . "\r\n";
		$reply_to	= 'Reply-To: ' . $this->_reply_to . "\r\n";
		
		return mail(
			$this->_email_address, 
			$this->_subject, 
			$this->_message, 
			$email_headers . $from . $reply_to
		);
	}
	
	/**
	 * Validate an email address
	 * 
	 * Returns true if the email address has the email address format and the 
	 * domain exists.
	 *
	 * @author Douglas Lovell, modified by Gabriel Liwerant
	 * @link http://www.linuxjournal.com/article/9585?page=0,3
	 * 
	 * @param string $email_address Email address to check for validity
	 * 
	 * @return boolean Result of the validity checks on the email address
	 */
	public function validateEmailAddress($email_address)
	{	  
		$is_valid = true;
		$at_index = strrpos($email_address, "@");

		if (is_bool($at_index) AND ! $at_index)
		{
		  $is_valid = false;
		}
		else
		{
			$domain			= substr($email_address, $at_index + 1);
			$local			= substr($email_address, 0, $at_index);
			$local_length	= strlen($local);
			$domain_length	= strlen($domain);

			if ( ($local_length < 1) OR ($local_length > 64) )
			{
				// local part length exceeded
				$is_valid = false;
			}
			elseif ( ($domain_length < 1) OR ($domain_length > 255) )
			{
				// domain part length exceeded
				$is_valid = false;
			}
			elseif ( ($local[0] === '.') OR ($local[$local_length - 1] === '.') )
			{
				// local part starts or ends with '.'
				$is_valid = false;
			}
			elseif (preg_match('/\\.\\./', $local))
			{
				// local part has two consecutive dots
				$is_valid = false;
			}
			elseif ( ! preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
			{
				// character not valid in domain part
				$is_valid = false;
			}
			elseif (preg_match('/\\.\\./', $domain))
			{
				// domain part has two consecutive dots
				$is_valid = false;
			}
			elseif ( ! preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace('\\\\', '', $local)) )
			{
				// character not valid in local part unless 
				// local part is quoted
				if ( ! preg_match('/^"(\\\\"|[^"])+"$/', str_replace('\\\\', '', $local)) )
				{
					$is_valid = false;
				}
			}
			if ( $is_valid AND ! (checkdnsrr($domain, 'MX') OR checkdnsrr($domain, 'A')) )
			{
				// domain not found in DNS
				$is_valid = false;
			}
		}

		return $is_valid;
	}
}
// End of Email Class

/* EOF lib/Email.php */