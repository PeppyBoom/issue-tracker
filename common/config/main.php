<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'name' => 'Issue tracker',
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'language' => 'ru-RU',
];
