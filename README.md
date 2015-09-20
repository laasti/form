# Laasti/form

## Installation

```
composer require laasti/form
```

## Usage

Forms have groups containing multiple fields.

```php

$form = new Laasti\Form\Form($data, $errors, $rules);
$form->setMethod('post'); //Defaults to post
$form->setAction('url');
$form->setAttributes([/*html attributes*/]);
$form->addField('text', 'field', 'Label', [/*choices*/], 'group', [/*input attributes*/], [/*row attributes*/]);
$form->removeField('field');
$form->removeGroup('group');
$form->setGroup('field', 'group');
$form->setLabel('field', 'Label');
$form->setType('field', 'type');
$form->setAttributes('field', [/*attributes*/]);
$form->setContainerAttributes('field', [/*attributes*/]);
$form->setData([]);
$form->setErrors([]);
$form->setRules([]);
$form->setGroupsLayout([
    'top',
    'main' => ['column1', 'column2'],
    'secondary' => ['side', 'wide'],
    'multi-level' => [
        'subsection' => ['sub-column1', 'sub-column2'],
        'subsection2'
    ]
]);
$form->defineGroup('group', 'Title', [/*attributes*/]);
```

Then in your view:

```php

$form->getAction(); //Get form action attribute
$form->getMethod(); //Get form method
$form->getFormAttributes(); //Get form attributes
$form->getAllFields(); //All fields without groups
$form->getFields(); //Just fields without groups
$group = array_shift($form->getGroups()); //Array of first level groups
$group->getLabel();
$group->getAttributes();
$group->getGroups(); //Array of subgroups
$field = array_shift($group->getFields()); //Array of fields in group
$field->getLabel();
$field->getName();
$field->getGroup();
$field->getChoices();
$field->getAttributes();
$field->getContainerAttributes();

//OR you can use magic properties instead of lengthy getters in views
$field->choices;
$field->containerAttributes;

```

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

See CHANGELOG.md for more information.

## Credits

Author: Sonia Marquette (@nebulousGirl)

## License

Released under the MIT License. See LICENSE.txt file.