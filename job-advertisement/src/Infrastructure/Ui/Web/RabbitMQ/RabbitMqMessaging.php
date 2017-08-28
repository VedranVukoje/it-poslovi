<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Web\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Connection\AMQPConnection;
/**
 * Description of RabbitMqMessaging
 *
 * @author vedran
 */
abstract class RabbitMqMessaging
{

    protected $connection;
    protected $channel;

    public function __construct(AMQPConnection $aConnection)
    {
        $this->connection = $aConnection;
        $this->channel = null;
    }

    private function connect($exchangeName)
    {
        if (null !== $this->channel) {
            return;
        }
        $channel = $this->connection->channel();
        $channel->exchange_declare($exchangeName, 'fanout', false, true, false);
        $channel->queue_declare($exchangeName, false, true, false, false);
        $channel->queue_bind($exchangeName, $exchangeName);
        $this->channel = $channel;
    }

    public function open($exchangeName)
    {
        
    }

    protected function channel($exchangeName)
    {
        $this->connect($exchangeName);
        return $this->channel;
    }
    
    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }

}
