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
use common\models\User;

class ServerWorker
{
    public $connections = [];

    private $wsWorker;
    private $innerTcpWorker;

    public function createWorker()
    {

        $connections = &$this->connections;
        $self = $this;

        $this->wsWorker = new Worker("websocket://0.0.0.0:1234");


        $this->wsWorker->onWorkerStart = function() use (&$self)
        {
            $self->createInnerWorker();
        };



        $this->wsWorker->onMessage = function () use (&$connections)
        {
            
        };



        $this->wsWorker->onConnect = function($connection) use (&$connections)
        {
            $connection->onWebSocketConnect = function($connection) use (&$connections)
            {
                if (isset($_GET['token']) && $this->checkToken($_GET['token'])) {

                    echo 'New connection' . PHP_EOL;
                    $connections[] = $connection;

                } else {

                    $connection->close('Bad request');

                }
            };
        };

        $this->wsWorker->onClose = function($connection) use(&$connections)
        {
            $user = array_search($connection, $connections);
            unset($connections[$user]);
        };

        $this->wsWorker->onError = function () {
            echo 'Socket error. Try to create a new instance';
            // SocketServer::run();
        };

        Worker::runAll();
    }

    private function createInnerWorker()
    {

        $connections = &$this->connections;

        $this->innerTcpWorker = new Worker("tcp://127.0.0.1:8080");

        $this->innerTcpWorker->onMessage = function($connection, $data) use (&$connections) {
            foreach($connections as $user)
            {   
                $user->send($data);
            }
        };

        $this->listen();
    }

    private function checkToken(string $token): bool
    {
        return User::find()->where(['auth_key' => $token])->exists();
    }

    public function listen()
    {
        $this->innerTcpWorker->listen();
    }
}

class SocketServer
{
    
    public static function run()
    {
        $serverWorker = new ServerWorker();
        $serverWorker->createWorker();
    }
}

SocketServer::run();
