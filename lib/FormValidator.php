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
 * FormValidator Class
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class FormValidator
{
	/**
	 * Store form validation messages.
	 *
	 * @var array $_form_validator_message
	 */
	private $_form_validator_message = array();
	
	/**
	 * Nothing to see here...
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Form validation messages setter
	 *
	 * @param string $key
	 * @param string $message 
	 * @return object FormValidator
	 */
	public function setFormValidatorMessage($key, $message)
	{
		$this->_form_validator_message[$key] = $message;
		
		return $this;
	}
	
	/**
	 * Form validation messages getter
	 *
	 * @param string $key
	 * @return string 
	 */
	public function getFormValidatorMessage($key)
	{
		return $this->_form_validator_message[$key];
	}
	
	/**
	 * Overwrite required field form validation message with an introduction and
	 * the specific field left empty.
	 *
	 * @param string $field_name The field that was left empty
	 * @param string $old_message_key Key to get old message for overwriting
	 */
	public function appendRequiredFieldNameToFormMessage($field_name, $old_message_key)
	{
		$old_message = $this->getFormValidatorMessage($old_message_key);
		
		$new_message = 
			'The '
			. ucfirst($field_name)
			. ' field is empty. ' 
			. $old_message;
		
		$this->setFormValidatorMessage($old_message_key, $new_message);
	}
	
	/**
	 * Run data through a honeypot check.
	 * 
	 * A honeypot is an input field in a form that is hidden with css. Because
	 * a normal user should not see it, it should remain empty when the form is
	 * submitted. If it is filled, we may assume it was filled by a bot, and we
	 * can handle the form as such.
	 *
	 * @param string $value Value to check
	 * @return boolean Result of check
	 */
	public function isValidAgainstHoneypot($value)
	{
		if ( ! empty($value))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * Run data through a spam check.
	 * 
	 * A spam check asks the user a question on a form that is intended to
	 * disqualify spam bots. We run the user-submitted data through our list of
	 * possible answers.
	 *
	 * @param array $spam_check_answer_data List of acceptable spam answers
	 * @param string $submitted_answer User-submitted answer
	 * @return boolean 
	 */
	public function isValidAgainstSpamCheck($spam_check_answer_data, $submitted_answer)
	{
		foreach ($spam_check_answer_data as $value)
		{
			if (strtolower($submitted_answer) === strtolower($value))
			{
				return true;
			}
		}

		return false;
	}
	
	/**
	 * Run data through a required field check.
	 * 
	 * A required field is one which must have data submitted to it in order to
	 * pass the check.
	 *
	 * @param string $submitted_data To check for any data
	 * @return boolean 
	 */
	public function isValidAgainstRequiredField($submitted_data)
	{
		if (empty($submitted_data))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}
// End of FormValidator Class

/* EOF lib/FormValidator.php */