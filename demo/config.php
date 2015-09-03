<?php

return [
    'layout' => [
        'main'
    ],
    'groups' => [
        'main' => [
            'label' => 'Main section',
            'attributes' => []
        ]
    ],
    'fields' => [
        //Full config
        [
            'type' => 'text',
            'name' => 'name',
            'label' => 'Label',
            'default' => 'no test',
            'group' => 'main',
            'choices' => [
                'Test', 'Test 2'
            ],
            'attributes' => [
                'class' => 'my-class'
            ],
            'container_attributes' => [
                'id' => 'some-container'
            ],
        ],
        [
            'type' => 'search',
            'name' => 'search',
            'label' => 'Search',
            'attributes' => ['placeholder' => 'I want to find...']
        ],
        [
            'type' => 'tel',
            'name' => 'phone',
            'group' => 'main',
            'label' => 'Phone'
        ],
        [
            'type' => 'email',
            'name' => 'email',
            'group' => 'main',
            'label' => 'E-mail address'
        ],
        [
            'type' => 'password',
            'name' => 'password',
            'group' => 'main',
            'label' => 'Password'
        ],
        [
            'type' => 'date',
            'name' => 'date',
            'group' => 'main',
            'label' => 'Date'
        ],
        [
            'type' => 'time',
            'name' => 'time',
            'group' => 'main',
            'label' => 'Time'
        ],
        [
            'type' => 'color',
            'name' => 'color',
            'group' => 'main',
            'label' => 'Color'
        ],
        [
            'type' => 'number',
            'name' => 'number',
            'group' => 'main',
            'label' => 'Number'
        ],
        [
            'type' => 'range',
            'name' => 'range',
            'group' => 'main',
            'label' => 'Range'
        ],
        [
            'type' => 'file',
            'name' => 'file',
            'group' => 'main',
            'label' => 'File'
        ],
        [
            'type' => 'textarea',
            'name' => 'textarea',
            'group' => 'main',
            'label' => 'Textarea'
        ],
        [
            'type' => 'output',
            'name' => 'output',
            'group' => 'main',
            'label' => 'Output'
        ],
        [
            'type' => 'meter',
            'name' => 'meter',
            'group' => 'main',
            'label' => 'Meter'
        ],
        [
            'type' => 'progress',
            'name' => 'progress',
            'group' => 'main',
            'label' => 'Progress',
            'default' => 5,
            'attributes' => [
                'max' => 10
            ]
        ],
        [
            'type' => 'select',
            'name' => 'simple_select',
            'group' => 'main',
            'label' => 'Select',
            'choices' => [
                '1' => 'Choice 1',
                '2' => 'Choice 2',
                '3' => 'Choice 3',
            ]
        ],
        [
            'type' => 'checkbox',
            'name' => 'multi_checkbox',
            'group' => 'main',
            'label' => 'Multi checkbox',
            'choices' => [
                '1' => 'Choice 1',
                '2' => 'Choice 2',
                '3' => 'Choice 3',
            ]
        ],
        [
            'type' => 'radio',
            'name' => 'radio',
            'group' => 'main',
            'label' => 'Radio',
            'choices' => [
                '1' => 'Choice 1',
                '2' => 'Choice 2',
                '3' => 'Choice 3',
            ]
        ],
        [
            'type' => 'select',
            'name' => 'group_select',
            'group' => 'main',
            'label' => 'Select',
            'choices' => [
                '1' => 'Choice 1',
                '2' => 'Choice 2',
                '3' => 'Choice 3',
                'Group 1' => [
                    '4' => 'Choice 4',
                    '5' => 'Choice 5',
                    '6' => 'Choice 6',
                ]
            ]
        ],
        [
            'type' => 'submit',
            'name' => 'submit',
            'group' => 'main',
            'label' => 'Send'
        ],
        [
            'type' => 'reset',
            'name' => 'reset',
            'group' => 'main',
            'label' => 'Reset'
        ],
        [
            'type' => 'button',
            'name' => 'button',
            'group' => 'main',
            'label' => 'Button'
        ],
        //minimal config
        [
            'type' => 'hidden',
            'name' => 'token',
        ]
    ]
];