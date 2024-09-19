<?php 

namespace App\Amqp;

interface  ConnectInterface  {
            public function connect(string $mensagem = null);
}