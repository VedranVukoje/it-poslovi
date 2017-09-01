<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain;

use JobAd\Domain\DomainEventPublisher;
/**
 *
 * @author vedran
 */
class AggregateRoot
{
    private $recordedEvents = [];
    
    protected function recordApplayAndPublihThat(DomainEvent $event)
    {
        $this->recordThat($event);
        $this->applyTaht($event);
        $this->publishThat($event);
    }
    
    protected function recordThat(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;
    }
    
    protected function applyTaht(DomainEvent $event)
    {
        
        $class = explode('\\', get_class($event));
        $modifier = 'apply'.array_pop($class);
        
        $this->$modifier($event);
    }
    
    protected function publishThat(DomainEvent $event) 
    {
        DomainEventPublisher::instance()->publish($event);
    }
    
    public function recordedEvents()
    {
        return $this->recordedEvents;
    }
    
    public function clearEvents()
    {
        $this->recordedEvents = [];
    }
    
    
}
