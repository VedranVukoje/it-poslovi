<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\InMemory;

use JobAd\Domain\EventStore;
use JobAd\Domain\DomainEvent;
/**
 * Description of InMemoryEventStorRepository
 *
 * @author vedran
 */
class InMemoryEventStorRepository implements EventStore
{
    
    private $eventStor;
    
    public function __construct()
    {
        $this->eventStor = [];
    }


    public function append(DomainEvent $domainEvent)
    {
        $this->eventStor[] = $domainEvent;
    }
    
    public function allStoredEventsSince($eventId)
    {
        
        return array_map(function($event){
            
        }, $this->eventStor);
    }
}
