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
    
    public static function createFromConfig($config, $data = [], $errors = [])
    {
        $form = new Form($data, $errors);
        if (isset($config['fields'])) {
            foreach ($config['fields'] as $key => $fc) {
                if (!isset($fc['name'])) {
                    trigger_error('Skipping index "'.$key.'". No name attibute.', E_USER_WARNING);
                    continue;
                }
                
                $fc = $fc + [
                    'type' => 'text',
                    'label' => null,
                    'default' => null,
                    'group' => null,
                    'choices' => [],
                    'errors' => [],
                    'attributes' => [],
                    'required' => false,
                    'container_attributes' => [],
                    'html' => null
                ];
                extract($fc);
                
                if (!isset($data[$name]) && !is_null($default)) {
                    $data[$name] = $default;
                }
                if ($required) {
                    $attributes["required"] = "required";
                }
                $field = $form->addField($type, $name, $label, $choices, $group, $attributes, $container_attributes, $html);
            }
            
            $form->setData($data);
            
            if (isset($config['layout'])) {
                $form->setGroupLayout($config['layout']);
            }
            
            if (isset($config['groups'])) {
                foreach ($config['groups'] as $groupname => $groupconfig) {
                    $groupconfig = $groupconfig + [
                        'label' => '',
                        'attributes' => []
                    ];
                    $form->defineGroup($groupname, $groupconfig['label'], $groupconfig['attributes']);
                }
            }
        }
        
        return $form;
    }
    
}
