<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Messaging\PhpAmqpLib\Consumer;

use Psr\Log\LoggerInterface;
use JobAd\Application\Contract\Serializer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Description of JobAdConsumer
 * 
 * @author vedran
 */
class EsJobAdConsumer implements ConsumerInterface
{

    private $serialize;
    private $log;

    public function __construct(Serializer $serialize, LoggerInterface $log)
    {
        $this->serialize = $serialize;
        $this->log = $log;
    }

    public function execute(AMQPMessage $msg)
    {
        
        $event = $this->serialize->deserialize($msg->body, $msg->get('type'), 'json');
        
        $this->log->debug('EsJobAdConsumer::execute ', ['eventId' => $event->id(),'type' => $msg->get('type')]);
        
//        echo $type = $msg->get('type');
    }

}
