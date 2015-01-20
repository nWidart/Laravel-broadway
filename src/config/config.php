<?php

return [
    'read-model' => 'elasticsearch',
    'read-model-connections' => [
        'elasticsearch' => [
            'config' => [
                'hosts' => ['localhost:9200'],
            ],
        ],
    ],
];
