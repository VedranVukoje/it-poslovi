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
use JobAd\Domain\Model\JobAdvertisement\Events\CategoryWasRemoveFromJobAd;
use JobAd\Infrastructure\Persistence\ElasticSearch\MessageDomainEventProcessing;

/**
 * Description of JobAdConsumer
 * 
 * @author vedran
 */
class EsJobAdConsumer implements ConsumerInterface
{

    private $serialize;
    private $log;
    private $process;

    public function __construct(Serializer $serialize, MessageDomainEventProcessing $process, LoggerInterface $log)
    {
        $this->serialize = $serialize;
        $this->process = $process;
        $this->log = $log;
    }

    public function execute(AMQPMessage $msg)
    {

        $event = $this->serialize->deserialize($msg->body, $msg->get('type'), 'json');
        
        if($event instanceof CategoryWasRemoveFromJobAd){
            $this->log->debug('Kategorija je obrisana: ',[
                'categoryId' => $event->categoryId()
            ]);
        }
        
        $this->log->debug('EsJobAdConsumer::execute ', [
            'type' => $msg->get('type'),
            'eventId' => (string) $event->id()
        ]);


        $this->process->dispatch($event);
    }

}
