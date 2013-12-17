<?php

return [
    'gii' => 'gii',
    'gii/<controller>' => 'gii/<controller>',
    'gii/<controller>/<action>' => 'gii/<controller>/<action>',
    
    '<action>' => 'site/<action>',
    '<controller:\w+>/index' => '<controller>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
];