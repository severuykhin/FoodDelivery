<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'cart'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'cart' => [
            'class' => 'frontend\components\Cart'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['ga_transaction_error'],
                    'logFile' => '@runtime/logs/ga.log',
                    'logVars' => []
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'sitemap' => [
                    'pattern' => 'sitemap',
                    'route' => 'site/sitemap',
                    'suffix' => '.xml',
                ],
                ''             => 'site/index',
                '/reviews'     => 'site/reviews',
                '/contacts'    => 'site/contacts',
                '/about'       => 'site/about',
                'menu/<slug>'  => 'menu/category',
                '/menu'         => 'menu/category',
                '/zakaz'       => 'cart/index',
                '/spasibo'     => 'site/spasibo',
                // '<action:(about|buy|contacts|reviews|spasibo|search|questions|cities|diler|diler-spasibo)>' => 'site/<action>',
                // '/<slug>'      => 'pages/page', 
                'cart/<action>'=> 'cart/<action>'
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
