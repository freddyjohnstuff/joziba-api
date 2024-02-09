<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => \yii\rest\UrlRule::class,
            'pluralize' => false,
            'controller' => [
                'v1/ads',
                'v1/ads-status',
                'v1/goods-category',
                'v1/goods-helpers',
            ],
            'prefix' => 'api',
            'patterns' => [
                'GET {id}' => 'view',
                'POST' => 'create',
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
                'v1/cpa-postbacks'
            ],
            'prefix' => 'api',
            'extraPatterns' => [
                'POST,GET recipient' => 'recipient',
            ],
        ],
        [
            'class' => \yii\rest\UrlRule::class,
            'pluralize' => false,
            'controller' => ['scores' => 'v1/partners-scores'],
            'prefix' => 'api/v1/partners/<partner_id:\\d+>',
            'patterns' => [
                'GET' => 'view',
                '{id}' => 'options',
                '' => 'options'
            ],
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
