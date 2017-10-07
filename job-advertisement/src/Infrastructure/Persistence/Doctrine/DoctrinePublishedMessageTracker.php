<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use JobAd\Domain\Event\PublishedMessage;
use JobAd\Application\Notification\PublishedMessageTracker;
use JobAd\Domain\Event\StoredEvent;
/**
 * Description of PublishedMessage
 *
 * @author vedran
 */
class DoctrinePublishedMessageTracker implements PublishedMessageTracker
{
    
    private $em;
    private $repo;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function mostRecentPublishedMessageId(string $exchangeName)
    {
        $messageTracked = $this->findOneByExchangeName($exchangeName);
        
        if(!$messageTracked){
            return null;
        }
        
        return $messageTracked->mostRecentPublishedMessageId();
        //
    }
    
    public function trackMostRecentPublishedMessage(string $exchangeName, StoredEvent $notification)
    {
        
        $maxId = $notification->eventId();
        
        $messageTracked = $this->findOneByExchangeName($exchangeName);
        if(!$messageTracked){
            $messageTracked = new PublishedMessage($exchangeName, $maxId);
        }
        
        $messageTracked->updateMostRecentPublishedMessageId($maxId);
        
        $this->em->persist($publishedMessage);
        $this->em->flush($publishedMessage);
    }
    
    private function findOneByExchangeName(string $exchangeName)
    {
        return $this->em->createQueryBuilder('p')
                ->select('p')
                ->from(PublishedMessage::class, 'p')
                ->where('p.exchangeName = :exchangeName')
                ->setParameter('exchangeName', $exchangeName)
                ->orderBy('p.trackerId', 'DESC')
                ->getQuery()
                ->getOneOrNullResult();
    }
}
