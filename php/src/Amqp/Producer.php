<?php 

namespace App\Amqp;

use PhpAmqpLib\Message\AMQPMessage;

class Producer  implements ConnectInterface {
    private ConnectAmqp $connectAmqp;
    public function __construct(public string $amqpurl)
    {
        $this->connectAmqp = new ConnectAmqp();
        $this->connectAmqp->connect();
    }

    public function connect(?string $mensagem = null)
    {
            $this->publish($mensagem);
    }

    private  function publish(string $mensagemBody =  null) 
    {
           $message = new AMQPMessage($mensagemBody, [
            'contant-type' => 'text/explain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
           ]);
           $this->connectAmqp->channel()->publish($message);
    }

}