<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Web\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;
/**
 * Description of RabbitMQProducer
 *
 * @author vedran
 */
class RabbitMQProducer extends RabbitMqMessaging
{
    public function send($exchangeName, $notificationMessage)
    {
        $this->channel($exchangeName)->basic_publish(new AMQPMessage($notificationMessage),$exchangeName);
    }
}
