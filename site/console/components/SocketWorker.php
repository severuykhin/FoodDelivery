<?php

namespace console\components;

class SocketWorker
{ 

    const LOCAL_SOCKET = 'tcp://127.0.0.1:8000';

    public static function send($data) {
        $instance = stream_socket_client(self::LOCAL_SOCKET);
        fwrite($instance, json_encode($data)  . "\n");
    }
}