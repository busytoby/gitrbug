<?php
/* SVN FILE: $Id: origami_form.php 2 2009-02-11 16:12:10Z busytoby $ */
/**
 * Form helper library.
 *
 * Automatic generation of HTML FORMs for origami date from given data.
 *
 * Origami(tm) :  CakePHP Data Management Framework
 * Copyright 2007-2009, EAS Technologies LLC
 * Licensed under The GNU Affero General Public License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @package       origami
 * @subpackage    origami.view.helpers
 * @copyright     Copyright 2007-2009, EAS Technologies LLC
 * @link          http://thechaw.com/origami Origami(tm) Project
 * @since         Origami(tm) v 0.8.9
 * @version       $Revision: 2 $
 * @modifiedby    $LastChangedBy: busytoby $
 * @lastmodified  $Date: 2009-02-11 11:12:10 -0500 (Wed, 11 Feb 2009) $
 * @license       http://www.fsf.org/licensing/licenses/agpl-3.0.html The GNU Affero General Public License
 */

App::import('Helper', 'Form');

class OrigamiFormHelper extends FormHelper {

    function input($fieldName, $options = array()) {
        if (ClassRegistry::isKeySet($this->model())) {
            $model =& ClassRegistry::getObject($this->model());
            if ($model->isOrigamiColumn($fieldName)) {
                    $type = $model->getOrigamiColumnType($fieldName);
                    if (method_exists($this, $type)) {
                        unset($options['type']);  // We are specifying the type, so we need to remove any user specified types
                        $out = $this->{$type}($fieldName, $options);

                        // The code is this section is mostly copied from the cake php
                        // FormHelper input method
                        $div = true;
                        $divOptions = array();

                        if (array_key_exists('div', $options)) {
                            $div = $options['div'];
                            unset($options['div']);
                        }

                        if (!empty($div)) {
                            $divOptions['class'] = 'input';
                            $divOptions = $this->addClass($divOptions, $type);
                            if (is_string($div)) {
                                $divOptions['class'] = $div;
                            } elseif (is_array($div)) {
                                $divOptions = array_merge($divOptions, $div);
                            }
                            if (in_array($this->field(), $this->fieldset['validates'])) {
                                $divOptions = $this->addClass($divOptions, 'required');
                            }
                            if (!isset($divOptions['tag'])) {
                                $divOptions['tag'] = 'div';
                            }
                        }

                        if ($type != 'hidden') {
                            $error = null;
                            if (isset($options['error'])) {
                                $error = $options['error'];
                                unset($options['error']);
                            }
                            if ($error !== false) {
                                $errMsg = $this->error($fieldName, $error);
                                if ($errMsg) {
                                    $out .= $errMsg;
                                    $divOptions = $this->addClass($divOptions, 'error');
                                }
                            }
                        }

                        if (isset($divOptions) && isset($divOptions['tag'])) {
                            $tag = $divOptions['tag'];
                            unset($divOptions['tag']);
                            $out = $this->Html->tag($tag, $out, $divOptions);
                        }
                        // end cake php inputs copy

                        return $out;
                    }
            }
        }

        return parent::input($fieldName, $options);
    }

    function origami_date($fieldName, $options = array()) {
        $options = array_merge($options, array('type' => 'date'));
        return $this->label($fieldName) . $this->datetime($fieldName, 'MDY', null, null, $options);
    }

    function origami_time($fieldName, $options = array()) {
        $options = array_merge($options, array('type' => 'time'));
        return $this->label($fieldName) . $this->datetime($fieldName, null, '12', null, $options);
    }

    function origami_ssn($fieldName, $options = array()) {
        $value = $this->value($fieldName);
        if(is_array($value))
            $value = implode('', $value);
        sscanf($value, '%3s%2s%4s', $areaNumber, $groupNumber, $serialNumber);

        $areaOptions = array('maxlength' => '3', 'value' => $areaNumber, 'type' => 'text', 'size' => '3');
        $groupOptions = array('maxlength' => '2', 'value' => $groupNumber, 'type' => 'text', 'size' => '2');
        $serialOptions = array('maxlength' => '4', 'value' => $serialNumber, 'type' => 'text', 'size' => '4');

        array_merge($areaOptions, $options);
        array_merge($groupOptions, $options);
        array_merge($serialOptions, $options);

        $out = $this->label($fieldName) .
                $this->text($fieldName.'.areaNumber', $areaOptions) . '-' .
                $this->text($fieldName.'.groupNumber', $groupOptions) . '-' .
                $this->text($fieldName.'.serialNumber', $serialOptions);

        return $out;
    }

    function origami_phone($fieldName, $options = array()) {
        $value = $this->value($fieldName);
        if(is_array($value))
            $value = implode('', $value);
        sscanf($value, '%3s%3s%4s', $areaCode, $prefix, $suffix);

        $areaCodeOptions = array('maxlength' => '3', 'value' => $areaCode, 'type' => 'text', 'size' => '3');
        $prefixOptions = array('maxlength' => '3', 'value' => $prefix, 'type' => 'text', 'size' => '3');
        $suffixOptions = array('maxlength' => '4', 'value' => $suffix, 'type' => 'text', 'size' => '4');

        array_merge($areaCodeOptions, $options);
        array_merge($prefixOptions, $options);
        array_merge($suffixOptions, $options);

        $out = $this->label($fieldName) .
                '(' . $this->text($fieldName.'.areaCode', $areaCodeOptions) . ') ' .
                $this->text($fieldName.'.prefix', $prefixOptions) . '-' .
                $this->text($fieldName.'.suffix', $suffixOptions);

        return $out;
    }

    function origami_postal($fieldName, $options = array()) {
        $value = $this->value($fieldName);
        if(is_array($value))
            $value = implode('', $value);
        if(strlen($value) == 9)
        {
            sscanf($value, '%5s%4s', $zipCode, $plusFour);
        }
        else
        {
            $zipCode = substr($value,0,5);
            $plusFour = '';
        }

        $zipCodeOptions = array('maxlength' => '5', 'value' => $zipCode, 'type' => 'text', 'size' => '5');
        $plusFourOptions = array('maxlength' => '4', 'value' => $plusFour, 'type' => 'text', 'size' => '4');

        array_merge($zipCodeOptions, $options);
        array_merge($plusFourOptions, $options);

        $out = $this->label($fieldName) .
                $this->text($fieldName.'.zipCode', $zipCodeOptions) . '-' .
                $this->text($fieldName.'.plusFour', $plusFourOptions);

        return $out;
    }
}

?>