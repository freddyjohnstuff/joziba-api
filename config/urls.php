<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    /*'enableStrictParsing' => true,*/
    'rules' => [
        [
            'class' => \yii\rest\UrlRule::class,
            'controller' => 'site'
        ],
        [
            'class' => \yii\rest\UrlRule::class,
            'pluralize' => false,
            'controller' => [
                'v1/ads',
                'v1/my-ads',
                'v1/ads-status',
                'v1/goods-category',
                'v1/goods-helpers',
                'v1/goods-helpers-value',
                'v1/helper-type',
                'v1/profile',
                'v1/service-goods',
                'v1/my-data',
                'v1/cities',
                'v1/media'
            ],
            'prefix' => 'api',
            'patterns' => [
                'GET {id}' => 'view',
                'POST' => 'create',
                'PUT {id}' => 'update',
                'GET' => 'index',
                'DELETE {id}' => 'delete',
                '{id}' => 'options',
                '' => 'options',
            ]
        ],
        [
            'class' => \yii\rest\UrlRule::class,
            'pluralize' => false,
            'controller' => [
                'v1/sign-up',
                'v1/sign-in',
                'v1/log-out',
                'v1/renew',
                'v1/reset',
            ],
            'prefix' => 'api',
            'patterns' => [
                'POST' => 'index',
                '' => 'options',
            ]
        ],
        [
            'class' => \yii\rest\UrlRule::class,
            'pluralize' => false,
            'controller' => ['payouts' => 'v1/partners-payouts'],
            'prefix' => 'api/v1/partners/<partner_id:\\d+>',
            'patterns' => [
                'GET {id}' => 'view',
                'POST' => 'create',
                'GET' => 'index',
                'DELETE {id}' => 'delete',
                '{id}' => 'options',
                '' => 'options',
            ],
        ]
    ],
];
