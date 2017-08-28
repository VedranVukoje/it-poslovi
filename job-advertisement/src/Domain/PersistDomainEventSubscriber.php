<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain;


/**
 * Description of PersistDomainEventSubscriber
 * 
 * @author vedran
 */
class PersistDomainEventSubscriber implements EventSubscriber
{
    
    private $eventStore;


    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }


    public function isSubscribedTo(DomainEvent $event)
    {
        return $event instanceof DomainEvent;
    }
    
    public function handle(DomainEvent $event)
    {
        $this->eventStore->append($event);
    }
}
