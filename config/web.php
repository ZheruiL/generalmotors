<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Europe/Paris',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => false,
            'enableCookieValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Admin',
            //'enableSession'=>false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            // 'traceLevel' => YII_DEBUG ? 3 : 0,
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning' /*,'info'*/],

                    'categories' => [
                        'yii\db\*',
                        'yii\web\HttpException:*',
                    ],
                    'except' => [
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:401',
                    ],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'admin',
                    'pluralize' => false,
                    'patterns' => [
                        'GET' => 'login',
                        'POST'=>'create'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'site',
                    'pluralize' => false,
                    'patterns' => [
                        'GET' => 'test',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'client',
                    'patterns' => [
                        'GET' => 'index',
                        'GET {id}' => 'view',
                        'POST' => 'create',
                        'PUT,PATCH {id}' => 'update',
                        'DELETE {id}' => 'delete',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'vehicle',
                    'patterns' => [
                        'GET' => 'index',
                        'GET {id}' => 'view',
                        'POST' => 'create',
                        'PUT,PATCH {id}' => 'update',
                        'DELETE {id}' => 'delete',

                        'PUT,PATCH increase-stock/{id}' => 'increase-stock',
                        'PUT,PATCH minus-stock/{id}' => 'minus-stock',

                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'order',
                    'patterns' => [
                        'GET' => 'index',
                        'GET {id}' => 'view',
                        'POST' => 'create',
                        'PUT,PATCH abandon/{id}' => 'abandon',
                        'PUT,PATCH confirm/{id}' => 'confirm',
                        'PUT,PATCH done/{id}' => 'done',
                        'PUT,PATCH cancel-confirm/{id}' => 'cancel-confirm',

                        'PUT,PATCH {id}' => 'update',
                        'DELETE {id}' => 'delete',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'orderline',
                    'patterns' => [
                        'GET' => 'index',
                        'GET {id}' => 'view',
                        'POST' => 'create',
                        'PUT,PATCH {id}' => 'update',
                        'DELETE {id}' => 'delete',
                    ]
                ],
            ],
        ],

    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
