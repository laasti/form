<?php

namespace Laasti\Form\Tests;

/**
 * FormTest Class
 *
 */
class FormTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $form = new \Laasti\Form\Form(['field1' => 'Test'], ['field1' => ['Non valide', 'required']]);
        $form->addField('text', 'field1', 'Test Field');

        $fields = $form->getFields();
        $field = array_shift($fields);

        $this->assertTrue($form->getAction() === $form->action);
        $this->assertTrue($field->getValue() === 'Test');
        $this->assertTrue($field->getValue() === $field->value);
        $this->assertTrue(count($field->getErrors()) === 2);
        $this->assertTrue($field->getError() === 'Non valide');
    }

    public function testFields()
    {
        $form = new \Laasti\Form\Form([]);
        $form->addField(
            'select',
            'country',
            'Country',
            ['ca' => 'Canada'],
            'group1',
            ['class' => 'my-class'],
            ['class' => 'container']
        );

        $field = $form->getField('country');

        $this->assertTrue($field->getType() === 'select');
        $this->assertTrue($field->getName() === 'country');
        $this->assertTrue($field->getLabel() === 'Country');
        $this->assertTrue($field->getGroup() === 'group1');
        $this->assertTrue($field->getChoices()['ca'] === 'Canada');
        $this->assertTrue($field->getAttributes()['class'] === 'my-class');
        $this->assertTrue($field->getContainerAttributes()['class'] === 'container');

        $form->setType('country', 'text');
        $form->setLabel('country', 'Pays');
        $form->setChoices('country', ['us' => 'United States']);
        $form->setGroup('country', 'group2');
        $form->setAttribute('country', 'class', 'my-class2');
        $form->setContainerAttribute('country', 'class', 'container2');

        $this->assertTrue($field->getType() === 'text');
        $this->assertTrue($field->getName() === 'country');
        $this->assertTrue($field->getLabel() === 'Pays');
        $this->assertTrue($field->getGroup() === 'group2');
        $this->assertTrue(!isset($field->getChoices()['ca']));
        $this->assertTrue($field->getChoices()['us'] === 'United States');
        $this->assertTrue($field->getAttributes()['class'] === 'my-class2');
        $this->assertTrue($field->getContainerAttributes()['class'] === 'container2');
        $this->assertTrue($field->isRequired === false);
        $this->assertTrue($field->isCountry === true);
        $this->assertTrue($field->isText === true);
    }

    public function testGroupsLayout()
    {
        $layout = [
            'main' => [
                'sub1',
                'sub2' => ['subsub'],
                'sub3' => ['subsub2']
            ]
        ];
        $form = new \Laasti\Form\Form([]);
        $form->setGroupLayout($layout);
        $form->addField('text', 'field1', '', [], null);
        $form->addField('text', 'field2', '', [], 'main');
        $form->addField('text', 'field3', '', [], 'sub1');
        $form->addField('text', 'field4', '', [], 'sub2');
        $form->addField('text', 'field5', '', [], 'subsub');
        $form->addField('text', 'field6', '', [], 'main');
        $form->addField('text', 'field7', '', [], 'subsub2');

        $this->assertTrue(count($form->getFields()) === 1);
        $this->assertTrue($form->getFields()[0]->getName() === 'field1');
        $groups = $form->getGroups();
        $this->assertTrue(count($groups) === 1);
        $this->assertTrue(count($groups[0]->getFields()) === 2);
        $this->assertTrue($groups[0]->getName() === $groups[0]->name);
        $subgroups = $groups[0]->getGroups();
        $this->assertTrue(count($subgroups) === 3);
        $this->assertTrue(count($subgroups[0]->getGroups()) === 0);
        $this->assertTrue(count($subgroups[0]->getFields()) === 1);
        $this->assertTrue(count($subgroups[1]->getGroups()) === 1);
        $this->assertTrue(count($subgroups[1]->getFields()) === 1);
        $this->assertTrue(count($subgroups[1]->getGroups()[0]->getFields()) === 1);
        $this->assertTrue(count($subgroups[2]->getFields()) === 0);
        $this->assertTrue(count($subgroups[2]->getGroups()[0]->getFields()) === 1);
    }

    public function testFromConfig()
    {
        $form = \Laasti\Form\FormFactory::createFromConfig(require 'config.php');

        $this->assertTrue(count($form->getFields()) === 1);
        $this->assertTrue(count($form->getAllFields()) === 2);
        $this->assertTrue(count($form->getGroups()) === 1);
        $this->assertEquals($form->getGroups()[0]->getLabel(), 'Main section');
    }
}
