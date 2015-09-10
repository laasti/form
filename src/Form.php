<?php

namespace Laasti\Form;

/**
 * Form Class
 *
 */
class Form
{

    const DEFAULT_GROUP = 'laasti-no-group';

    protected $method = 'post';
    protected $action = '';
    protected $formAttributes;
    protected $data = [];
    protected $errors = [];
    protected $fields = [];
    protected $groups = [];
    protected $rootGroups = [];
    protected $groupsLayout;
    protected $fileFields = [];

    public function __construct($data, $errors = [])
    {
        $this->data = $data;
        $this->errors = $errors;
        $this->formAttributes = new Attributes();
    }

    public function addField($type, $name, $label = null, $choices = [], $group = null, $attributes = [], $containerAttributes = [])
    {
        if ($type === 'file') {
            $this->fileFields[] = $name;
        }
        if (isset($this->fields[$name])) {
            throw new \RuntimeException('The field "' . $name . '" is already defined.');
        }
        $group = is_null($group) ? self::DEFAULT_GROUP : $group;
        $this->fields[$name] = new Field($type, $name, $label, $choices, $group, $attributes, $containerAttributes);
        $this->fields[$name]->setValue($this->getData($name));
        $this->fields[$name]->setErrors($this->getErrors($name));
        $this->setGroup($name, $group);

        return $this;
    }

    public function setGroup($fieldname, $group)
    {
        if (!isset($this->groups[$group])) {
            $this->defineGroup($group, '', []);
        }

        //Remove from old group
        $this->groups[$this->fields[$fieldname]->getGroup()]->removeField($fieldname);
        //Add to new group
        $this->fields[$fieldname]->setGroup($group);
        $this->groups[$group]->addField($this->fields[$fieldname]);

        return $this;
    }

    public function removeField($fieldname)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $group = $this->fields[$fieldname]->getGroup();
        $this->groups[$group]->removeField($fieldname);
        if ($this->fields[$fieldname]->getType() === 'file') {
            unset($this->fileFields[array_search($fieldname, $this->fileFields)]);
        }
        unset($this->fields[$fieldname]);

        return $this;
    }

    public function removeGroup($group)
    {
        if (!isset($this->groups[$group])) {
            throw new \OutOfBoundsException('The group "' . $group . '" does not exist.');
        }
        foreach ($this->groups[$group]->getFields() as $fieldname => $field) {
            if ($this->fields[$fieldname]->getType() === 'file') {
                unset($this->fileFields[array_search($fieldname, $this->fileFields)]);
            }
            unset($this->fields[$fieldname]);
        }
        unset($this->groups[$group]);

        return $this;
    }

    public function setLabel($fieldname, $label)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->setLabel($label);

        return $this;
    }

    public function setType($fieldname, $type)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->setType($type);

        return $this;
    }

    public function setAttribute($fieldname, $attribute, $value)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->setAttribute($attribute, $value);

        return $this;
    }

    public function removeAttribute($fieldname, $attribute)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->removeAttribute($attribute);

        return $this;
    }

    public function setAttributes($fieldname, $attributes)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->setAttributes($attributes);

        return $this;
    }

    public function setChoices($fieldname, $choices)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->setChoices($choices);

        return $this;
    }

    public function setContainerAttribute($fieldname, $attribute, $value)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->setContainerAttribute($attribute, $value);

        return $this;
    }

    public function removeContainerAttribute($fieldname, $attribute)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->removeContainerAttribute($attribute);

        return $this;
    }

    public function setContainerAttributes($fieldname, $attributes)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }

        $this->fields[$fieldname]->setContainerAttributes($attributes);

        return $this;
    }

    public function setGroupLayout($layout)
    {
        $this->groupsLayout = $layout;
        return $this;
    }

    public function defineGroup($group, $label, $attributes = [])
    {
        if (isset($this->groups[$group])) {
            $this->groups[$group]->setLabel($label);
            $this->groups[$group]->setAttributes($attributes);
        } else {
            $this->groups[$group] = new Group($group, $label, $attributes);
        }

        return $this;
    }

    public function getAllFields()
    {
        return array_values($this->fields);
    }

    public function getField($fieldname)
    {
        if (!isset($this->fields[$fieldname])) {
            throw new \OutOfBoundsException('The field "' . $fieldname . '" does not exist.');
        }
        return $this->fields[$fieldname];
    }

    public function getFields()
    {
        return array_values($this->groups[self::DEFAULT_GROUP]->getFields());
    }

    public function getGroups()
    {
        if (is_null($this->groupsLayout)) {
            $groups = $this->groups;
            unset($groups[self::DEFAULT_GROUP]);
            return array_values($groups);
        }

        $this->arrangeGroupsByLayout();
        return array_values($this->rootGroups);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getFormAttributes()
    {
        if (count($this->fileFields)) {
            $this->formAttributes->setAttribute('enctype', 'multipart/form-data');
        }
        return $this->formAttributes;
    }

    public function getData($fieldname = null)
    {
        if (!is_null($fieldname)) {
            return isset($this->data[$fieldname]) ? $this->data[$fieldname] : null;
        }
        return $this->data;
    }

    public function getErrors($fieldname = null)
    {
        if (!is_null($fieldname)) {
            return isset($this->errors[$fieldname]) ? $this->errors[$fieldname] : null;
        }
        return $this->errors;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function setFormAttribute($attribute, $value)
    {
        $this->formAttributes->setAttribute($attribute, $value);
        return $this;
    }

    public function removeFormAttribute($attribute)
    {
        $this->formAttributes->removeAttribute($attribute);
        return $this;
    }

    public function setFormAttributes($attributes)
    {
        $this->formAttributes->setAttributes($attributes);
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        foreach ($data as $fieldname => $fielddata) {
            if (isset($this->fields[$fieldname])) {
                $this->fields[$fieldname]->setValue($fielddata);
            }
        }
        return $this;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
        foreach ($errors as $fieldname => $fielderrors) {
            if (isset($this->fields[$fieldname])) {
                $this->fields[$fieldname]->setErrors($fielderrors);
            }
        }
        return $this;
    }

    protected function arrangeGroupsByLayout()
    {
        if (is_null($this->groupsLayout)) {
            return $this;
        }

        foreach ($this->groupsLayout as $key => $value) {

            $group = is_string($value) ? $value : $key;
            $subgroups = is_array($value) ? $value : [];

            if (!isset($this->groups[$group]) && count($subgroups) === 0) {
                continue;
            } else if (!isset($this->groups[$group])) {
                $this->defineGroup($group, '');
            }

            $this->rootGroups[$group] = $this->groups[$group];

            if (count($subgroups)) {
                $this->addGroupsToParent($subgroups, $group);
            }
        }
    }

    protected function addGroupsToParent($sublayout, $parent)
    {
        foreach ($sublayout as $key => $value) {
            $group = is_string($value) ? $value : $key;
            $subgroups = is_array($value) ? $value : [];

            if (!isset($this->groups[$group]) && count($subgroups) === 0) {
                continue;
            } else if (!isset($this->groups[$group])) {
                $this->defineGroup($group, '');
            }

            $this->groups[$parent]->addGroup($this->groups[$group]);

            if (count($subgroups)) {
                $this->addGroupsToParent($subgroups, $group);
            }
        }
    }

}
