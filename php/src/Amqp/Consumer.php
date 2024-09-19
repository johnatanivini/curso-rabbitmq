<?php 

namespace App\Amqp;

class Consumer implements ConnectInterface {

    public function __construct(public string $amqpurl)
    {
        
    }
    public function connect(string $mensagem = null)
    {
            
    }

}