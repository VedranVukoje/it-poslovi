<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use JobAd\Application\Contract\Serializer;
//use Doctrine\ORM\EntityRepository;
use JobAd\Domain\DomainEvent;
use JobAd\Domain\EventStore;
use JobAd\Domain\Event\StoredEvent;
/**
 * Description of StoredEventDoctrineRepository
 * JobAd\Infrastructure\Persistence\Doctrine\StoredEventDoctrineRepository
 * @author vedran
 */
class StoredEventDoctrineRepository implements EventStore
{
    
    private $em;
    private $serialize;
    
    public function __construct(EntityManager $em, Serializer $serialize)
    {
        $this->em = $em;
        $this->serialize = $serialize;
    }


    public function append(DomainEvent $event)
    {
        $typeName = get_class($event);
        $occurredOn = $event->occurredOn();
        $eventBody = $this->serialize->serialize($event, 'json');
        $storedEvent = new StoredEvent($typeName, $event->occurredOn(), $eventBody);
        
        $this->em->persist($storedEvent);
    }
    
    public function allStoredEventsSince($eventId)
    {
        ;
    }
}
