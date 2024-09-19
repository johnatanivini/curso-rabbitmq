<?php 

namespace App\Amqp;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class ConnectAmqp  {
                private AMQPChannel $channel;
                private string $exchange;
                private string $queue;
                private AMQPStreamConnection $connection;
                public function connect() 
                {
                    $this->exchange = 'alertas';
                    $this->queue = 'msgs';
                     $this->connection = new AMQPStreamConnection($_ENV['AMQP_HOST'],$_ENV['AMQP_PORT'],$_ENV['AMQP_USER'],$_ENV['AMQP_PASS'],$_ENV['AMQP_VHOST']);
                     $channel = $this->connection->channel();
                     $channel->queue_declare($this->queue, false, true, false,false);
                     $channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
                     $channel->queue_bind($this->queue, $this->exchange);
                     $this->channel =  $channel;
                }
                
                public function channel()
                {
                    $this->channel;
                    return $this;
                }

                public function publish(AMQPMessage $message) 
                {
                        $this->channel->basic_publish($message, $this->exchange);
                        return $this;
                }

                public function close() 
                {
                    $this->channel->close();
                    $this->connection->close();
                }
}