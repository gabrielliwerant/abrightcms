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
	 * @param string $maxlength Maxlength attribute
	 * @param string $value Value attribute
	 * @param string $size Size attrivute
	 * @param boolean $is_required Tells us if field is required or not
	 * @param string $icon_class Class name for icon or empty
	 */
	public function setTextArea(
		$name, 
		$id, 
		$maxlength, 
		$value			= null, 
		$size			= null,
		$is_required	= false,
		$icon_class		= null
	)
	{
		$field			= $this->_buildField($name, $id, $maxlength, null, $value, $size);		
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
		
		if (is_array($option_data))
		{
			foreach ($option_data as $text => $value)
			{
				$option .= '<option value="' . $value . '">' . $text . '</option>';
			}
		}
		else
		{
			// @todo error if no option_data
		}

		$field		= $this->_buildField($name, $id, null);
		$required	= $this->_buildRequired($is_required, $field, null);
		
		$select_field = '<select ' . $field . ' >' . $option . '</select>' . $required;
		
		$this->_setField($id, $select_field);
	}
	
	/**
	 * Build the HTML form from all the appropriate properties with any desired
	 * id or enclosing tag for the individual fields and return the built form.
	 *
	 * @param string $field_tag_type HTML tag to enclose fields with
	 * @param string $id Form id
	 * @return string Built HTML form
	 */
	public function getForm($field_tag_type = null, $name = null, $id = null)
	{
		$fields = null;
				
		foreach ($this->_fields as $field_id => $field)
		{
			// Find matching labels to connect to other form fields
			foreach ($this->_labels as $for => $label)
			{
				if ($for === $field_id)
				{
					$field = $label . $field;
					
					break;
				}
			}
			
			if ( ! empty($field_tag_type))
			{
				$fields .= $this->_htmlTagWrap($field_tag_type, $field);
			}
			else
			{
				$fields .= $field;
			}
		}
		
		$action				= $this->_form_action;
		$method				= $this->_form_method;
		$form['action']		= null;
		$form['method']		= null;
		$form['name']		= null;
		$form['id']			= null;
		$form_attributes	= null;
		
		foreach ($form as $attribute => $value)
		{
			$form_attributes .= $attribute . '="' . $$attribute . '" ';
		}
		
		$built_form = '<form ' . $form_attributes . ' >' . $fields . '</form>';

		return $built_form;
	}
	
	/**
	 * Allows us to enclose parts of our form in an HTML tag.
	 *
	 * @param string $tag_type The HTML tag to enclose with
	 * @param string $inner The HTML to enclose
	 * @return string The enclosed HTML
	 */
	private function _htmlTagWrap($tag_type, $inner)
	{
		$enclosed = '<' . $tag_type . '>' . $inner . '</' . $tag_type . '>';
		
		return $enclosed;
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
			if ( ! empty($key))
			{
				$attribute	= $key . '="' . $$key . '"';
				$field		.= $attribute . ' ';
			}
		}
		
		return $field;
	}
	
	/**
	 * Checks whether or not a field is required, and if it is, whether or not
	 * any data has been submitted in it.
	 *
	 * @param string $field_data The data for the field we are checking
	 * @param string $required_value The requirement value of the field (yes/no)
	 * @return boolean Whether or not the required field is filled
	 */
	private function _isRequiredFieldFilled($field_data, $required_value)
	{
		$is_required = (boolean)$required_value;

		if ($is_required)
		{
			if ( ! empty($field_data))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * Checks whether or not a field is used for checking against spam, and if
	 * so, compare the data submitted to the requested answer.
	 *
	 * @param string $spam_field_data Spam field data to compare to answer
	 * @param string $spam_check_value The spam check value for the field
	 * @param array $spam_check_answer_data Spam check answers for comparison
	 * @return boolean Whether the spam check field was satisfied correctly
	 */
	private function _isSpamCheckAnswerValid(
		$spam_field_data, 
		$spam_check_value,
		$spam_check_answer_data
	)
	{
		$is_spam_check_field = (boolean)$spam_check_value;

		if ($is_spam_check_field)
		{
			foreach ($spam_check_answer_data as $value)
			{
				if (strtolower($spam_field_data) === strtolower($value))
				{
					return true;
				}
			}
			
			return false;
		}
		else
		{
			return true;
		}
		
		return true;
	}
	
	/**
	 * Validate data against any spam checking.
	 *
	 * @param array $submitted_data Form data to check against
	 * @return boolean Result of our validation
	 */
	public function validateSpamCheck($submitted_data)
	{
		foreach ($this->field_meta as $name => $field_values)
		{
			if ( isset($field_values['is_spam_check']) AND isset($field_values['spam_check_answer']) )
			{
				$is_spam_check_answer_valid = $this->_isSpamCheckAnswerValid(
					$submitted_data[$name], 
					$field_values['is_spam_check'], 
					$field_values['spam_check_answer']
				);
				
				if ( ! $is_spam_check_answer_valid)
				{
					return false;
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Validate data against required fields.
	 *
	 * @param array $submitted_data Form data to check against
	 * @param boolean $does_append_err_msg If we should append our error message
	 * @return boolean Result of our validation
	 */
	public function validateRequiredFields($submitted_data, $does_append_err_msg = false)
	{
		foreach ($this->field_meta as $name => $field_values)
		{			
			if (isset($field_values['is_required']))
			{
				$is_required_field_filled = $this->_isRequiredFieldFilled(
					$submitted_data[$name], 
					$field_values['is_required']
				);				
				
				if ( ! $is_required_field_filled)
				{
					// Append the name of the field to the message for display
					if ($does_append_err_msg)
					{
						$this->form_messages['required_field'] = 
							ucfirst($name)
							. ' ' 
							. $this->form_messages['required_field'];
					}
					
					return false;
				}
			}
		}
		
		return true;
	}
}
// End of Form Class

/* EOF lib/Form.php */