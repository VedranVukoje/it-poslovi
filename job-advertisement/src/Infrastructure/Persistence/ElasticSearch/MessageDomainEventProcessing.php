<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch;

use Psr\Log\LoggerInterface;
use JobAd\Domain\EventSubscriber;
use JobAd\Domain\DomainEvent;


/**
 * Description of MessageDomainEventProcessing
 *
 * @author vedran
 */
class MessageDomainEventProcessing
{
    
    private $log;
    private $id = 0;
    private $subscribers = [];
    
    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }
    
    public function subscribe(EventSubscriber $subscriber)
    {
        $id = $this->id;
        $this->subscribers[$id] = $subscriber;
        ++$this->id;
    }

    public function dispatch(DomainEvent $event)
    {
        foreach ($this->subscribers as $subscriber){
            if($subscriber->isSubscribedTo($event)){
                $subscriber->handle($event);
            }
        }
    }

}
