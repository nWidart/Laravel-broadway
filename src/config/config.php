<?php

return [
    'read-model' => 'elastic-search',
    'read-model-connections' => [
        'elastic-search' => [
            'config' => [
                'hosts' => ['localhost:9200']
            ],
            'index' => 'read-model'
        ],
    ],
];
