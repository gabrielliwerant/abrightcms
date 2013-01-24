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
class FormBuilder
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
	 * Stores all the field meta data
	 *
	 * @var array $_field_meta
	 */
	private $_field_meta = array();
	
	/**
	 * Upon construction, we set the form action, method, and any form messages.
	 *
	 * @param string $form_action
	 * @param string $form_method
	 */
	public function __construct($form_action = null, $form_method = null)
	{
		$this->_setFormAction($form_action)->_setFormMethod($form_method);
	}
	
	/**
	 * Form action setter
	 *
	 * @param string $form_action
	 * 
	 * @return object FormBuilder
	 */
	private function _setFormAction($form_action)
	{
		$this->_form_action = $form_action;
		
		return $this;
	}
	
	/**
	 * Form method setter
	 *
	 * @param string $form_method
	 * 
	 * @return object FormBuilder
	 */
	private function _setFormMethod($form_method)
	{
		$this->_form_method = $form_method;
		
		return $this;
	}
	
	/**
	 * Sets a form field in our array property as a key => value pair.
	 *
	 * @param string $key Key to use as identifier for value
	 * @param string $field The value to store
	 * 
	 * @return object FormBuilder
	 */
	private function _setField($key, $field)
	{
		$this->_fields[$key] = $field;
		
		return $this;
	}
	
	/**
	 * Build HTML label
	 *
	 * @param string $for For attribute for label
	 * @param string $text Text portion of label
	 * 
	 * @return string 
	 */
	private function _buildLabel($for, $text)
	{
		return '<label for="' . $for . '">' . $text . '</label>';
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
	 * 
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
	 * 
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
	 * 
	 * @return object FormBuilder
	 */
	public function setFieldMeta($key, $meta_data)
	{
		$this->_field_meta[$key] = $meta_data;
		
		return $this;
	}
	
	/**
	 * Get a specific field's meta data.
	 *
	 * @param string $key Field to return meta data for
	 * 
	 * @return array 
	 */
	public function getFieldMeta($key)
	{
		return $this->_field_meta[$key];
	}
	
	/**
	 * All field meta data getter
	 *
	 * @return array All stored field meta data
	 */
	public function getAllFieldMeta()
	{
		return $this->_field_meta;
	}
	
	/**
	 * Setter for labels, which first creates them with the appropriate HTML.
	 *
	 * @param string $for For value for label
	 * @param string $text Text portion of label
	 * 
	 * @return object FormBuilder
	 */
	public function setLabel($for, $text)
	{
		$label = $this->_buildLabel($for, $text);
		
		$this->_labels[$for] = $label;
		
		return $this;
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
	 * 
	 * @return object FormBuilder
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
		
		return $this;
	}
	
	/**
	 * Builds and then sets a textarea field.
	 *
	 * @param string $name Name attribute
	 * @param string $id Field id
	 * @param boolean $is_required Tells us if field is required or not
	 * @param string $icon_class Class name for icon or empty
	 * 
	 * @return object FormBuilder
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
		
		return $this;
	}
	
	/**
	 * Public-facing setter for form select fields, which builds them with the 
	 * appropriate HTML.
	 *
	 * @param string $name Name attribute
	 * @param array $option_data Data to use for building the select options
	 * @param string $id Select id
	 * 
	 * @return object FormBuilder
	 */
	public function setSelect(
		$name, 
		$option_data, 
		$id, 
		$is_required = false,
		$icon_class	= null
	)
	{
		$option = null;		
		foreach ($option_data as $text => $value)
		{
			$option .= '<option value="' . $value . '">' . $text . '</option>';
		}

		$field		= $this->_buildField($name, $id, null);
		$required	= $this->_buildRequired($is_required, $field, $icon_class);
		
		$select_field = '<select ' . $field . '>' . $option . '</select>' . $required;
		
		$this->_setField($id, $select_field);
		
		return $this;
	}
	
	/**
	 * Get stored field data based on array key.
	 *
	 * @param string $key
	 * 
	 * @return string 
	 */
	public function getField($key)
	{
		return $this->_fields[$key];
	}
	
	/**
	 * Get the array property with all the stored fields.
	 *
	 * @return array All the fields for the form
	 */
	public function getAllFields()
	{
		return $this->_fields;
	}

	/**
	 * Find the matching label to connect to the correct field and return it.
	 *
	 * @param string $field_key Key of field to find matching label for
	 * 
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
	 * 
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
		
		$built_form = '<form ' . $form_attributes . '>' . $fields . '</form>';

		return $built_form;
	}
	
	/**
	 * Searches through fields for an email field and then matches against user
	 * submitted data in a field with the same name.
	 *
	 * @param array $submitted_data Form data to look through
	 * 
	 * @return string/boolean Either the submitted email address or false
	 */
	public function findUserEnteredEmail($submitted_data)
	{
		foreach ($this->_field_meta as $name => $field_data)
		{
			if (isset($field_data['is_email']))
			{
				$is_email = (boolean)$field_data['is_email'];
				
				if ($is_email AND isset($submitted_data[$name]))
				{
					return $submitted_data[$name];
				}
				elseif ($is_email AND ! isset($submitted_data[$name]) )
				{
					return false;
				}
			}
		}
		
		return false;
	}
}
// End of Form Class

/* EOF lib/Form.php */