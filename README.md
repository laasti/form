# Laasti/form

## Installation

```
composer require laasti/form
```

## Usage

Forms have groups containing multiple fields.

```php

$form = new Laasti\Form\Form($method, $action, $attributes, $data, $errors, $rules);
$form->addField('text', 'field', 'Label', 'group', [/*input attributes*/], [/*row attributes*/]);
$form->setLayout([
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

$form->action(); //Get form action attribute
$form->method(); //Get form method
$form->attributes(); //Get form attributes
$form->fields(); //All fields without groups
$group = array_shift($form->groups()); //Array of first level groups
$group->label();
$group->attributes();
$group->groups(); //Array of subgroups
$field = array_shift($group->fields()); //Array of fields in group
$field->label();
$field->name();
$field->group();
$field->choices();
$field->attributes();
$field->containerAttributes();

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