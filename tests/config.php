<?php

return [
    'layout' => [
        'main'
    ],
    'groups' => [
        'label' => 'Main section',
        'attributes' => []
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
            'errors' => [
                'My error'
            ],
            'rules' => [
                'some-rules'
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