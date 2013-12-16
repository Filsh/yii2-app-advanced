<?php
return [
    'adminEmail' => 'admin@example.com',
    
    'components.urlManager' => [
        'showScriptName' => false,
        'enablePrettyUrl' => true,
        'suffix' => '.html',
        'rules' => require(__DIR__ . '/routes.php'),
    ]
];
