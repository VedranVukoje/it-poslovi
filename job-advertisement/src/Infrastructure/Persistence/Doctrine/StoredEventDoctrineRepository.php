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
        $eventBody = $this->serialize->serialize($event, 'json');
        $typeName = get_class($event);
        $occurredOn = $event->occurredOn();
        
        $storedEvent = new StoredEvent($typeName, $event->occurredOn(), $eventBody);
        
        $this->em->persist($storedEvent);
    }
    
    public function allStoredEventsSince($eventId)
    {
        return $this->em->createQueryBuilder('e')
                ->select('e')
                ->from(StoredEvent::class, 'e')
                ->where('e.eventId > :eventId')
                ->setParameter('eventId', $eventId)
                ->orderBy('e.eventId', 'ASC')
                ->getQuery()
                ->getResult();
    }
    
    public function ofEventId($eventId)
    {
        return $this->em->find(StoredEvent::class, $eventId);
    }
}
