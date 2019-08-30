<?php

namespace console\controllers; 

use console\components\SocketServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class SocketController extends  \yii\console\Controller
{
    public function actionStart()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketServer()
                )
            ),
            8080
        );
    
        $server->run();
    }

    public function actionTest()
    {
        $localsocket = 'tcp://127.0.0.1:8000';
        $user = 'tester01';
        $message = 'test';

        // соединяемся с локальным tcp-сервером
        $instance = stream_socket_client($localsocket);
        // отправляем сообщение
        fwrite($instance, json_encode(['user' => $user, 'message' => $message])  . "\n");
    }
}