<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Laasti\Form;

/**
 * Description of FormFactory
 *
 * @author Sonia
 */
class FormFactory
{
    private static $fieldsDefaults = [
        'type' => 'text',
        'label' => null,
        'default' => null,
        'group' => null,
        'choices' => [],
        'errors' => [],
        'attributes' => [],
        'required' => false,
        'container_attributes' => [
            'class' => 'form-field form-field-{type}'
        ],
        'html' => null
    ];

    private static $groupsDefaults = [
        'label' => '',
        'attributes' => [
            'class' => 'form-group'
        ],
    ];

    public static function createFromConfig($config, $data = [], $errors = [])
    {
        $form = new Form($data, $errors);
        if (isset($config['fields'])) {
            if (isset($config['defaults']) && isset($config['defaults']['fields'])) {
                $field_defaults = $config['defaults']['fields'] + self::$fieldsDefaults;
            } else {
                $field_defaults = self::$fieldsDefaults;
            }
            foreach ($config['fields'] as $key => $fc) {
                if (!isset($fc['name'])) {
                    trigger_error('Skipping index "' . $key . '". No name attibute.', E_USER_WARNING);
                    continue;
                }

                extract(self::parseDynamicValues(array_replace_recursive($field_defaults, $fc)));

                if (!isset($data[$name]) && !is_null($default)) {
                    $data[$name] = $default;
                }
                if ($required) {
                    $attributes["required"] = "required";
                }
                $field = $form->addField($type, $name, $label, $choices, $group, $attributes, $container_attributes,
                    $html);
            }

            $form->setData($data);

            if (isset($config['layout'])) {
                $form->setGroupLayout($config['layout']);
            }

            if (isset($config['groups'])) {
                foreach ($config['groups'] as $groupname => $groupconfig) {
                    $groupconfig = array_replace_recursive(self::$groupsDefaults, $groupconfig);
                    $form->defineGroup($groupname, $groupconfig['label'], $groupconfig['attributes']);
                }
            }
        }

        return $form;
    }

    private static function parseDynamicValues($config, $original_config = null)
    {
        if (is_null($original_config)) {
            $original_config = $config;
        }
        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $config[$key] = self::parseDynamicValues($value, $config);
            } elseif (is_string($value)) {
                $matches = [];
                if (preg_match('/\{([a-zA-Z]+)\}/', $value, $matches)) {
                    $config[$key] = str_replace($matches[0],
                        (isset($original_config[$matches[1]]) ? $original_config[$matches[1]] : ''), $value);
                }
            }
        }

        return $config;
    }

    public static function setFieldsDefaults($defaults)
    {
        self::$fieldsDefaults = array_replace_recursive(self::$fieldsDefaults, $defaults);
    }

    public static function setGroupsDefaults($defaults)
    {
        self::$groupsDefaults = array_replace_recursive(self::$groupsDefaults, $defaults);
    }
}
