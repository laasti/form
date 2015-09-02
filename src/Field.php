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
    protected $attributes;
    protected $containerAttributes;

    public function __construct($type, $name, $label, $choices = [], $group = null, $attributes = [], $containerAttributes = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->choices = $choices;
        $this->group = $group;
        $this->attributes = new Attributes($attributes);
        $this->containerAttributes = new Attributes($containerAttributes);
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

    public function getAttributes()
    {
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

    public function getError()
    {
        if (empty($this->errors)) {
            return null;
        }
        $keys = array_keys($this->errors);
        return $this->errors[array_shift($keys)];
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

    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
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

}
