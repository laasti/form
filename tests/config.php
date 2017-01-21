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
                'Test',
                'Test 2'
            ],
            'attributes' => [
                'class' => 'my-class'
            ],
            'container_attributes' => [
                'id' => 'some-container'
            ],
        ],
        //minimal config
        [
            'type' => 'hidden',
            'name' => 'token',
        ]
    ]
];
