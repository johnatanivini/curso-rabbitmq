<?php

require_once 'vendor/autoload.php';

print("================================\r\n");

App\Classes\DotEnv::init();

$amqpUrl = $_ENV['CLOUDMAP_URL'];


print("\r\n================================\r\n");

$arquivo = $argv[0];
$tipo = $argv[1];
$mensagem = $argv[3] ?? "";

switch ($tipo) {
        case '--producer': 
            $producer = new App\Amqp\Producer($amqpUrl);
            $producer->connect($mensagem);
            break;
        case '--consumer':
            $consumer = new App\Amqp\Consumer($amqpUrl);
            $consumer->connect();
}