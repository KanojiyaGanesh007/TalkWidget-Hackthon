<?php

return [
    'routes' => [
        [
            'name' => 'message#getMessages',
            'url' => '/api/messages',
            'verb' => 'GET'
        ],
        [
            'name' => 'message#sendMessage',
            'url' => '/api/send',
            'verb' => 'POST'
        ],
    ]
];
