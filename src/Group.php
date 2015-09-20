<?php

namespace Laasti\Form;

/**
 * Group Class
 *
 */
class Group
{

    protected $name;
    protected $label;
    protected $attributes;
    protected $fields = [];
    protected $groups = [];

    public function __construct($name, $label = '', $attributes = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->attributes = new Attributes($attributes);
    }

    public function addField(Field $field)
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    public function removeField($fieldname)
    {
        unset($this->fields[$fieldname]);
        return $this;
    }

    public function addGroup(Group $group)
    {
        $this->groups[$group->getName()] = $group;
        return $this;
    }

    public function removeGroup($groupname)
    {
        unset($this->groups[$groupname]);
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getFields()
    {
        return array_values($this->fields);
    }

    public function getGroups()
    {
        return array_values($this->groups);
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
