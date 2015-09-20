<?php

namespace Laasti\Form;

/**
 * Field Class
 *
 */
class Field
{

    //put your code here
    protected $type;
    protected $name;
    protected $label;
    protected $group;
    protected $value;
    protected $errors;
    protected $choices;
    protected $html;
    protected $attributes;
    protected $containerAttributes;
    protected $factoryClass = 'Laasti\Form\ElementsGenerator';

    public function __construct($type, $name, $label, $choices = [], $group = null, $attributes = [], $containerAttributes = [], $html = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->choices = $choices;
        $this->group = $group;
        $this->html = $html;
        $this->attributes = new Attributes($attributes);
        $this->containerAttributes = new Attributes($containerAttributes);
        //$this->containerAttributes->setAttribute('class', 'form-field form-field-'.$type);
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function getHtml()
    {
        return $this->hmtl;
    }

    public function getAttributes()
    {
        $this->getId();
        return $this->attributes;
    }

    public function getContainerAttributes()
    {
        return $this->containerAttributes;
    }

    public function getChoices()
    {
        return $this->choices;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getControl()
    {
        return !is_null($this->html) ? $this->html : call_user_func_array([$this->factoryClass, 'render'.ucfirst($this->getType())], [$this]);
    }

    public function getError()
    {
        if (empty($this->errors)) {
            return null;
        }
        $keys = array_keys($this->errors);
        return $this->errors[array_shift($keys)];
    }

    public function isButton()
    {
        return in_array($this->getType(), ['reset', 'submit', 'button']);
    }

    public function hasFakeLabel()
    {
        return in_array($this->getType(), ['radio']) || ($this->getType() === 'checkbox' && count($this->getChoices()) > 1);
    }

    public function hasLabel()
    {
        return !in_array($this->getType(), ['hidden', 'reset', 'submit', 'button', 'image', 'meter', 'progress', 'radio','checkbox']) || ($this->getType() === 'checkbox' && count($this->getChoices()) < 2);
    }

    public function hasNoLabel()
    {
        return in_array($this->getType(), ['hidden', 'submit', 'button', 'image', 'meter', 'progress']);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getId()
    {
        if (!isset($this->attributes['id'])) {
            $this->attributes['id'] = uniqid($this->name);
        }
        return  $this->attributes['id'];
    }

    public function getFactoryClass()
    {
        return $this->factoryClass;
    }

    public function setFactoryClass($factoryClass)
    {
        $this->factoryClass = $factoryClass;
        return $this;
    }

    
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = htmlspecialchars((string)$value, ENT_QUOTES);
        return $this;
    }

    
    public function setChoices($choices)
    {
        $this->choices = $choices;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributes->setAttribute($attribute, $value);
        return $this;
    }

    public function removeAttribute($attribute)
    {
        $this->attributes->removeAttribute($attribute);
        return $this;
    }

    public function setAttributes($attributes)
    {
        $this->attributes->setAttributes($attributes);
        return $this;
    }

    public function setContainerAttribute($attribute, $value)
    {
        $this->containerAttributes->setAttribute($attribute, $value);
        return $this;
    }

    public function removeContainerAttribute($attribute)
    {
        $this->containerAttributes->removeAttribute($attribute);
        return $this;
    }

    public function setContainerAttributes($containerAttributes)
    {
        $this->containerAttributes->setAttributes($containerAttributes);
        return $this;
    }

    public function __isset($name)
    {
        return method_exists($this, 'get' . ucfirst($name));
    }

    public function __get($name)
    {
        if (method_exists($this, 'get' . ucfirst($name))) {
            return call_user_func([$this, 'get' . ucfirst($name)]);
        }

        return null;
    }

}
