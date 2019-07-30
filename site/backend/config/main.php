<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'verbs' => ['POST', 'GET', 'DELETE']
            ],
            // [
            //     'actions' => ['login', 'error'],
            //     'allow' => true,
            // ],
            // [
            //     'roles' => ['@'],
            //     'allow' => true,
            // ],
        ],
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'baseUrl' => '/backend',
            'class' => 'yii\web\UrlManager',
            'rules' => [
                'photos/<action>'    => 'photos/<action>',
                '/category/<action>' => 'category/<action>',
                'menu/<action>'      => 'menu/<action>',
                'crm/orders'         => 'crm/index',
                'crm/customers'      => 'crm/index',
                'crm/products'       => 'crm/index',
                'crm/reports'        => 'crm/index',
                'reviews/<action>'   => 'reviews/<action>',
                'pages/<action>'     => 'pages/<action>'
            ]
        ],
        'frontendUrlManager' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'd MMMM yyyy HH:mm:ss'
        ],
    ],
    'params' => $params,
];
