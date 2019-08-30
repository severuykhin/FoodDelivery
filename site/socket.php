<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/common/config/bootstrap.php');
require(__DIR__ . '/frontend/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/common/config/main.php'),
    require(__DIR__ . '/common/config/main-local.php'),
    require(__DIR__ . '/frontend/config/main.php'),
    require(__DIR__ . '/frontend/config/main-local.php')
);

$application = new yii\web\Application($config);

use Workerman\Worker;

$users = [];

$ws_worker = new Worker("websocket://0.0.0.0:1234");
$ws_worker->onWorkerStart = function() use (&$users)
{
    $inner_tcp_worker = new Worker("tcp://127.0.0.1:8000");
    $inner_tcp_worker->onMessage = function($connection, $data) use (&$users) {

        // if (isset($users[$data->user])) {
        //     $webconnection = $users[$data->user];
        //     $webconnection->send($data->message);
        // }

        foreach($users as $user)
        {   
            $user->send($data);
        }
    };
    $inner_tcp_worker->listen();
};

$ws_worker->onMessage = function () use (&$users)
{
   // TO DO message request 
};

$ws_worker->onConnect = function($connection) use (&$users)
{
    $connection->onWebSocketConnect = function($connection) use (&$users)
    {
        $users[] = $connection;
    };
};

$ws_worker->onClose = function($connection) use(&$users)
{
    $user = array_search($connection, $users);
    unset($users[$user]);
};

Worker::runAll();