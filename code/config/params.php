<?php

use kartik\datecontrol\Module;

return [
    'adminEmail' => 'admin@example.com',
    'environment' => 'dev',
    'icon-framework' => 'fa',
    'dateControlDisplay' => [
        Module::FORMAT_DATE => 'dd/MM/yyyy',
        Module::FORMAT_TIME => 'hh:mm:ss a',
        Module::FORMAT_DATETIME => 'dd/MM/yyyy hh:mm:ss a',
    ],

    // format settings for saving each date attribute (PHP format example)
    'dateControlSave' => [
        Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
        Module::FORMAT_TIME => 'php:H:i:s',
        Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
    ],
    'sessionDuration' => 60
];
