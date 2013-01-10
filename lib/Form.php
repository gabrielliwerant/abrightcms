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
 * Form Class
 * 
 * Allows us to build, store, and return an HTML form with any form fields, 
 * inputs, labels, and formatting necessary.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class Form
{
	/**
	 * Stores the form action.
	 *
	 * @var string $_form_action
	 */
	private $_form_action;
	
	/**
	 * Stores the form method.
	 *
	 * @var string $_form_method
	 */
	private $_form_method;	
	
	/**
	 * Stores any labels for our form.
	 *
	 * @var array $_labels
	 */
	private $_labels = array();
	
	/**
	 * Stores any form input fields for our form.
	 *
	 * @var array $_fields
	 */
	private $_fields = array();
	
	/**
	 * Stores POST URL in case it differs from the form action.
	 *
	 * @var string $form_post
	 */	
	public $form_post;
	
	/**
	 * Stores messages to display for errors/success
	 *
	 * @var array $form_messages
	 */
	public $form_messages = array();
	
	/**
	 * Stores all the field meta data
	 *
	 * @var array $field_meta
	 */
	public $field_meta = array();
	
	/**
	 * Upon construction, we set the form action, post URL, method, and any form
	 * messages.
	 *
	 * @param string $form_action
	 * @param string $form_post
	 * @param string $form_method
	 * @param string $form_messages
	 */
	public function __construct(
		$form_action	= null, 
		$form_post		= null, 
		$form_method	= null, 
		$form_messages	= null
	)
	{
		$this->_setFormAction($form_action);
		$this->_setFormPost($form_post);
		$this->_setFormMethod($form_method);
		$this->_setFormMessages($form_messages);
	}
	
	/**
	 * Store the form action.
	 *
	 * @param string $form_action The form action
	 */
	private function _setFormAction($form_action)
	{
		$this->_form_action = $form_action;
	}
	
	/**
	 * Store the form POST URL.
	 *
	 * @param string $form_post The form POST URL
	 */
	private function _setFormPost($form_post)
	{
		$this->form_post = $form_post;
	}
	
	/**
	 * Store the form method.
	 *
	 * @param string $form_method The form method
	 */
	private function _setFormMethod($form_method)
	{
		$this->_form_method = $form_method;
	}
	
	/**
	 * Store the form messages.
	 *
	 * @param string $form_messages The form messages
	 */
	private function _setFormMessages($form_messages)
	{
		$this->form_messages = $form_messages;
	}
	
	/**
	 * Sets a form field label in our array property as a key => value pair.
	 *
	 * @param string $key Key to use as identifier for value
	 * @param string $label The value to store
	 */
	private function _setLabel($key, $label)
	{
		$this->_labels[$key] = $label;
	}
	
	/**
	 * Sets a form field in our array property as a key => value pair.
	 *
	 * @param string $key Key to use as identifier for value
	 * @param string $field The value to store
	 */
	private function _setField($key, $field)
	{
		$this->_fields[$key] = $field;
	}
	
	/**
	 * Helps us build our fields by adding required class and required icon.
	 * 
	 * We pass the field by reference so that changes are made to it out of the
	 * function.
	 *
	 * @param boolean $is_required Tells us if field is required or not
	 * @param string &$field The field we are currently building
	 * @param string $icon_class Class name for icon or empty
	 * @return string The required icon class
	 */
	private function _buildRequired($is_required, &$field, $icon_class = null)
	{
		if ((boolean)$is_required)
		{
			$field .= 'class="required"';
			
			if ( ! empty($icon_class))
			{
				$required = '<i class="' . $icon_class . '"></i>';
			}
			else
			{
				$required = null;
			}
		}
		else
		{
			$required = null;
		}
		
		return $required;
	}
	
	/**
	 * Builds our form field from passed in data.
	 *
	 * @param string $name Name attribute
	 * @param string $id Field id
	 * @param string $maxlength Maxlength attribute
	 * @param string $type Type attribute
	 * @param string $value Value attribute
	 * @param string $size Size attribute
	 * @return string Built form field with necessary attributes
	 */
	private function _buildField(
		$name, 
		$id, 
		$maxlength, 
		$type			= null, 
		$value			= null, 
		$size			= null
	)
	{
		$input['name']			= null;
		$input['id']			= null;
		$input['maxlength']		= null;
		$input['type']			= null;
		$input['value']			= null;
		$input['size']			= null;

		$field = null;
		foreach ($input as $key => $val)
		{
			if ( ! empty($$key))
			{
				$attribute	= $key . '="' . $$key . '"';
				$field		.= $attribute . ' ';
			}
		}
		
		return $field;
	}
	
	/**
	 * Allows us to populate a property with meta data for our fields.
	 *
	 * @param string $key Key name for field array
	 * @param array $meta_data Array with meta data for field
	 */
	public function setFieldMeta($key, $meta_data)
	{
		$this->field_meta[$key] = $meta_data;
	}
	
	/**
	 * Public-facing setter for labels, which builds them with the appropriate
	 * HTML as well as a line-break if desired.
	 *
	 * @param string $for For value for label
	 * @param string $text Text portion of label
	 */
	public function setLabel($for, $text)
	{
		$label	= '<label for="' . $for . '">' . $text . '</label>';		
		
		$this->_setLabel($for, $label);
	}
	
	/**
	 * Builds and then sets an input field.
	 *
	 * @param string $name Name attribute
	 * @param string $id Field id
	 * @param string $maxlength Maxlength attribute
	 * @param string $type Type attribute
	 * @param string $value Value attribute
	 * @param string $size Size attrivute
	 * @param boolean $is_required Tells us if field is required or not
	 * @param string $icon_class Class name for icon or empty
	 */
	public function setInput(
		$name, 
		$id, 
		$maxlength, 
		$type			= null, 
		$value			= null, 
		$size			= null,
		$is_required	= false,
		$icon_class		= null
	)
	{
		$field			= $this->_buildField($name, $id, $maxlength, $type, $value, $size);		
		$required		= $this->_buildRequired($is_required, $field, $icon_class);
		$input_field	= '<input ' . $field . '/>' . $required;
		
		$this->_setField($id, $input_field);
	}
	
	/**
	 * Builds and then sets a textarea field.
	 *
	 * @param string $name Name attribute
	 * @param string $id Field id
	 * @param boolean $is_required Tells us if field is required or not
	 * @param string $icon_class Class name for icon or empty
	 */
	public function setTextArea(
		$name, 
		$id, 
		$is_required	= false,
		$icon_class		= null
	)
	{
		$field			= $this->_buildField($name, $id, null, null, null, null);		
		$required		= $this->_buildRequired($is_required, $field, $icon_class);
		$input_field	= '<textarea ' . $field . '></textarea>' . $required;
		
		$this->_setField($id, $input_field);
	}
	
	/**
	 * Public-facing setter for form select fields, which builds them with the 
	 * appropriate HTML.
	 *
	 * @param string $name Name attribute
	 * @param array $option_data Data to use for building the select options
	 * @param string $id Select id
	 */
	public function setSelect($name, $option_data, $id, $is_required = false)
	{
		$option = null;		
		foreach ($option_data as $text => $value)
		{
			$option .= '<option value="' . $value . '">' . $text . '</option>';
		}

		$field		= $this->_buildField($name, $id, null);
		$required	= $this->_buildRequired($is_required, $field, null);
		
		$select_field = '<select ' . $field . ' >' . $option . '</select>' . $required;
		
		$this->_setField($id, $select_field);
	}
	
	/**
	 * Get the array property with all the stored fields.
	 *
	 * @return array All the fields for the form
	 */
	public function getFields()
	{
		return $this->_fields;
	}

	/**
	 * Find the matching label to connect to the correct field and return it.
	 *
	 * @param string $field_key Key of field to find matching label for
	 * @return string Matching label
	 */
	public function getLabelMatchingFieldKey($field_key)
	{
		foreach ($this->_labels as $for => $label)
		{
			if ($for === $field_key)
			{
				return $label;
			}
		}
	}
	
	/**
	 * Build the HTML form from all the appropriate properties with any desired
	 * id and individual fields and return the built form.
	 *
	 * @param string $fields HTML fields to enclose in form
	 * @param string $id Form id
	 * @return string Built HTML form
	 */
	public function getForm($fields, $name = null, $id = null)
	{
		$action				= $this->_form_action;
		$method				= $this->_form_method;
		
		$form['action']		= null;
		$form['method']		= null;
		$form['name']		= null;
		$form['id']			= null;
		
		$form_attributes = null;		
		foreach ($form as $attribute => $value)
		{
			$form_attributes .= $attribute . '="' . $$attribute . '" ';
		}
		
		$built_form = '<form ' . $form_attributes . ' >' . $fields . '</form>';

		return $built_form;
	}
	
	/**
	 * Runs a honeypot check for the form.
	 * 
	 * A honeypot is an input field in a form that is hidden with css. Because
	 * a normal user should not see it, it should remain empty when the form is
	 * submitted. If it is filled, we may assume it was filled by a bot, and we
	 * can handle the form as such.
	 *
	 * @param array $submitted_data Form data to check against
	 * @param string $honeypot_field_name Field name to check
	 * @return string Send the data back upon failure, empty upon success 
	 */
	public function validateHoneypot($submitted_data, $honeypot_field_name)
	{
		foreach ($this->field_meta as $name => $field_values)
		{
			if (isset($field_values[$honeypot_field_name]))
			{
				$is_honeypot = (boolean)$field_values[$honeypot_field_name];

				if ($is_honeypot)
				{
					if ( ! empty($submitted_data[$name]))
					{
						// Return the value upon failure for logging
						return $submitted_data[$name];
					}
				}
			}
		}
		
		return null;
	}
	
	/**
	 * Validate data against any spam checking.
	 * 
	 * If we find a spam check field, we loop through the correct values to find
	 * a match. If we do, we have passed the validation. If the loop doesn't 
	 * find any true answers, we have failed validation. If there are no spam 
	 * check fields, we have passed the validation.
	 *
	 * @param array $submitted_data Form data to check against
	 * @param string $spam_check_field_name Field name to check for spam
	 * @param string $spam_check_answer_field_name Answer field name to check
	 * @return boolean Result of our validation
	 */
	public function validateSpamCheck(
		$submitted_data, 
		$spam_check_field_name,
		$spam_check_answer_field_name
	)
	{
		foreach ($this->field_meta as $name => $field_values)
		{
			if ( isset($field_values[$spam_check_field_name]) AND isset($field_values[$spam_check_answer_field_name]) )
			{
				$is_spam_check_field = (boolean)$field_values[$spam_check_field_name];

				if ($is_spam_check_field)
				{
					foreach ($field_values[$spam_check_answer_field_name] as $value)
					{
						if (strtolower($submitted_data[$name]) === strtolower($value))
						{
							return true;
						}
					}

					return false;
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Validate data against required fields.
	 * 
	 * We use a loop to search for values in required fields and exit as soon as
	 * we find an empty field with a required value. Otherwise, we have passed
	 * verification.
	 *
	 * @param array $submitted_data Form data to check against
	 * @param string $required_field_name Field name to check for required
	 * @param string $required_message_field_name Field name to check for message
	 * @param boolean $does_append_err_msg If we should append our error message
	 * @return boolean Result of our validation
	 */
	public function validateRequiredFields(
		$submitted_data, 
		$required_field_name,
		$required_message_field_name,
		$does_append_err_msg = false
	)
	{
		foreach ($this->field_meta as $name => $field_values)
		{			
			if (isset($field_values[$required_field_name]))
			{
				$is_required = (boolean)$field_values[$required_field_name];

				if ($is_required)
				{
					if (empty($submitted_data[$name]))
					{
						// Append the name of the field to the message for display
						if ($does_append_err_msg)
						{
							$this->form_messages[$required_message_field_name] = 
								'The '
								. ucfirst($name)
								. ' field is empty. ' 
								. $this->form_messages[$required_message_field_name];
						}

						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Searches through fields for an email field and then matches against user
	 * submitted data in a field with the same name.
	 *
	 * @param array $submitted_data Form data to look through
	 * @return string/boolean Either the submitted email address or false
	 */
	public function getUserEnteredEmail($submitted_data)
	{
		foreach ($this->field_meta as $name => $field_values)
		{
			if (isset($field_values['is_email']))
			{
				$is_email = (boolean)$field_values['is_email'];
				
				if ($is_email)
				{
					return $submitted_data[$name];
				}
			}
		}
		
		return false;
	}
}
// End of Form Class

/* EOF lib/Form.php */