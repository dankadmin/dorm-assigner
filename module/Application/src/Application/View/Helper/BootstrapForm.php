<?php
/**
 * Bootstrap Form Source Code
 *
 * @category DormAssigner
 * @package DormAssigner\Application\View\Helper
 * @subpackage BootstrapForm
 * @copyright Copyright (c) Daniel King
 * @version $Id$
 * @author Daniel K <danielk@inmotionhosting.com>
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Bootstrap Form View Helper
 *
 * Handles details for forms for updating and creating students
 *
 * @category DormAssigner
 * @package DormAssigner\Application\View\Helper
 * @subpackage BootstrapForm
 * @copyright Copyright (c) Daniel King
 * @version $$Id$$
 * @author Daniel K <danielk@inmotionhosting.com>
 */
class BootstrapForm extends AbstractHelper
{
    /** CONSTANTS **/
    /** @var string TAB_STRING String to act as tabs for formatted output. */
    const TAB_STRING = '    ';

    /** PROPERTIES **/
    /** @var \Zend\Form\Form $_form Form which is being viewed. */
    private $_form;
    /** @var string $_output Holds output which is intended to be displayed at the end of __invoke */
    private $_output;
    /** @var array $_custom_options Custom configuration options sent by __invoke */
    private $_custom_options;
    /** @var string $_indention_level Holds the current indention level */
    private $_indention_level;
    /** @var string $_input_width Width of bootstrap columns for input fields, from 1 to 12. */
    private $_input_width;
    /** @var string $_label_width Width of bootstrap columns for labels, from 1 to 12. */
    private $_label_width;

   /**
    * addOutput
    *
    * Add a string to the HTML output
    *
    * @param string $text text to add to the output
    * @param int $indention_change Number of indention levels, positive or negative, to alter current level. Defaults to 0.
    * @param boolean $newline Whether to add a newline to the end of the text. Defautls to true.
    *
    */
    private function addOutput($text, $indention_change=0, $newline=true)
    {
        if ($indention_change < 1) {
            $this->_indention_level += $indention_change;
        }
        
        if ($this->_indention_level > 0) {
            $this->_output .= str_repeat(self::TAB_STRING, $this->_indention_level);
        }

        $this->_output .= $text;

        if ($newline) {
            $this->_output .= "\n";
        }

        if ($indention_change >= 1) {
            $this->_indention_level += $indention_change;
        }
    }

   /**
    * getValidatorsString
    *
    * Determine which validators should be present on form element
    *
    * @param string $name
    *
    * @return string HTML for adding validators
    */
    private function getValidatorsString($name)
    {
        $validator_string = '';

        $validators = $this->_form
                      ->getInputFilter()
                      ->get($name)
                      ->getValidatorChain()
                      ->getValidators();

        if (count($validators) < 1) {
            return '';
        }

        foreach ($validators as $validator) {
            $validator_name = get_class($validator['instance']);
            $validator_name = preg_replace('@.*\\\\@', '', $validator_name);
            $validator_string .= "$validator_name ";
        }

        return 'validate="' . rtrim($validator_string) . '" ';
    }

   /**
    * Get option
    *
    * Get a single configurable option from the custom options array or return default
    *
    * @param string $option_name Name of option to get
    * @param mixed $default Default value to return if none is in array
    *
    * @return mixed
    */
    private function getOption($option_name, $default)
    {
        if (isset($this->_custom_options[$option_name])) {
            $value = $this->_custom_options[$option_name];

            $option_type = gettype($default);
            if (gettype($value) != $option_type) {
                throw new BootstrapFormException("Option '$option_name' is not $option_type");
            }

            return $this->_custom_options[$option_name];
        } else {
            return $default;
        }
    }

   /**
    * Set options
    *
    * Set configurable options from array of options
    *
    * @param array $options Array of options to set
    *
    */
    private function setOptions($options=array())
    {
        $this->_custom_options = $options;

        $this->_indention_level = $this->getOption('indent', 3);

        $this->_input_width = $this->getOption('input-width', 9);
        $this->_label_width = 12 - $this->_input_width;
    }

   /**
    * Add Form Element
    *
    * Add a specific form element to the output.
    *
    * @param \Zend\Form\Element $element Form element to add.
    */
    public function addFormElement($element)
    {
        $this->addOutput('<div class="form-group">', 1);

        $type = $element->getAttribute('type');
        $name = $element->getAttribute('name'); 
        $value = $element->getValue();
        $label = $element->getLabel();
        $id = $element->getAttribute('id'); 

        $validation_string = $this->getValidatorsString($name);

        $required_string = '';
        if ($element->getOption('required')) {
            $required_string = 'required="required" ';
        }

        if ($type != 'hidden' && $type != 'submit') {
            $this->addOutput(
                '<label class="control-label col-xs-' . $this->_label_width . '">' . $label . '</label>'
            );

            $this->addOutput('<div class="col-xs-' . $this->_input_width . '">', 1);
        }

        if ($type == 'hidden') { 

            $this->addOutput(
                '<div class="hidden">'
                    . '<input type="hidden" '
                    . 'name="' . $name . '" '
                    . 'value="' . $value . '" '
                    . '/>'
                    . '</div>'
            );

        } else if ($type == 'submit') {

            if ($element->getValue()) {
                $value = $element->getValue();
            } elseif ($element->getAttribute('value')) {
                $value = $element->getAttribute('value');
            } elseif ($element->getAttribute('caption')) {
                $value = $element->getAttribute('caption');
            } else {
                $value = 'Submit';
            }

            $this->addOutput('<div class="col-xs-offset-3 col-xs-10">', 1);
            $this->addOutput(
                '<input type="submit" class="btn btn-primary submit-btn" '
                    . 'value="' . $value . '" id="' . $id
                    . '" name="' . $name . '" />'
            );
            $this->addOutput('</div>', -1);

        } else if ($type == 'select') {

            $this->addOUtput(
                '<select class="form-control" name="' . $name . '" '
                    . $validation_string
                    . $required_string
                    . ">",
                1
            );

            foreach ($element->getValueOptions() as $key => $text) {
                if ($value == $key) {
                    $selected = 'selected="selected" ';
                } else {
                    $selected = '';
                }

                $this->addOutput('<option value="' . $key . '" ' . $selected . '>' . $text . '</option>');
            }

            $this->addOutput('</select>', -1);

        } else if ($type == 'radio') {

            foreach ($element->getValueOptions() as $key => $text) {
                if ($value == $key) {
                    $checked = 'checked="checked" ';
                } else {
                    $checked = '';
                }

                $this->addOutput('<div class="radio-inline">', 1);
                $this->addOutput(
                    '<input type="radio" name="' . $name . '" value="' . $key . '" '
                        . $required_string
                        . $checked
                        . '/>'
                        . '<span>' . $text . '</span>'
                );
                $this->addOutput('</div>', -1);
            }

        } else if ($label != '') {

            $this->addOutput(
                '<input class="form-control" name="' . $name . '" type="' . $type . '" '
                    . $validation_string
                    . $required_string
                    . 'value="' . $value . '" '
                    . ' />'
            );

        }

        if ($type != 'hidden' && $type != 'submit') {
            $this->addOutput('</div>', -1);
        }

        $this->addOutput('</div>', -1);
    }

   /**
    * Invoke
    *
    * Invoke the View Helper
    *
    * @param Form
    *
    * @return string HTML coded for Bootstrap 3
    */
    public function __invoke($form, $options=array())
    {
        if (! $form instanceof \Zend\Form\Form) {
            throw new BootstrapFormException("Expected Zend\Form\Form for parameter 1,");
        }

        if (! is_array($options)) {
            throw new BootstrapFormException("Expected array for parameter 2,");
        }

        $this->_form = $form;

        $this->setOptions($options);

        $this->_output = '';

        $this->_form->prepare();


        $form_name = $this->_form->getName();
        if ($this->_form->getAttribute('class')) {
            $form_class = $this->_form->getAttribute('class');
        } else {
            $form_class = 'form-horizontal';
        }

        $this->addOutput(
            '<form method="POST" '
                . 'class="' . $form_class . '" '
                . 'name="' . $form_name . '" '
                . 'id="' . $form_name . '" '
                . '>',
            1
        );

        foreach ($this->_form as $element) {
            $this->addFormElement($element);
        }

        $this->addOutput('</form>', -1);

        return $this->_output;
    }
}

/**
 * Bootstrap Form View Helper Exception
 *
 * Exceptions for Bootstrap Form View Helper
 *
 * @category DormAssigner
 * @package DormAssigner\Application\View\Helper
 * @subpackage BootstrapFormException
 * @copyright Copyright (c) Daniel King
 * @version $$Id$$
 * @author Daniel K <danielk@inmotionhosting.com>
 */
class BootstrapFormException extends \Exception {}

