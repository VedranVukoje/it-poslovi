<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Notification;

use Psr\Log\LoggerInterface;
//use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement as JobAd;
use JobAd\Application\Contract\Messaging;
use JobAd\Domain\Event\StoredEvent;
use JobAd\Domain\EventStore;
use JobAd\Application\Contract\Serializer;
use JobAd\Application\Notification\PublishedMessageTracker;

/**
 * Description of NotificationService
 *
 * @author vedran
 */
class NotificationService
{

    private $eventStore;
    private $publishedMessageTracker;
    private $serializer;
    private $messaging;
    private $log;
    
    /**
     * @todo Prebaci dependency u factory .   
     * @param EventStore $eventStore
     * @param PublishedMessageTracker $publishedMessageTracker
     * @param Serializer $serializer
     * @param Messaging $messaging
     * @param LoggerInterface $log
     */
    public function __construct(
    EventStore $eventStore, PublishedMessageTracker $publishedMessageTracker, Serializer $serializer, Messaging $messaging, LoggerInterface $log)
    {
        $this->eventStore = $eventStore;
        $this->publishedMessageTracker = $publishedMessageTracker;
        $this->serializer = $serializer;
        $this->messaging = $messaging;
        $this->log = $log;
    }

    public function publishNotifications(string $exchangeName)
    {

        $publishedMessageTracker = $this->publishedMessageTracker();
        $trackId = $publishedMessageTracker->mostRecentPublishedMessageId($exchangeName);

        $notifications = $this->listUnpublishedNotifications((int) $trackId);
        
        try {
            
            $publishedMassage = 0;
            
            if (0 < count($notifications)) {
                foreach ($notifications as $storedEvent) {
                    
                    $lastPublishedNotification = $this->publish($storedEvent);
                    $publishedMassage++;
                }

                $publishedMessageTracker->trackMostRecentPublishedMessage($exchangeName, $lastPublishedNotification);
            }
        } catch (Exception $ex) {
            dump($ex);
        }

        return $publishedMassage;
    }

    private function publishedMessageTracker()
    {
        return $this->publishedMessageTracker;
    }

    private function listUnpublishedNotifications($mostRecentPublishedMessageId)
    {
        return $this->eventStore->allStoredEventsSince($mostRecentPublishedMessageId);
    }

    private function publish(StoredEvent $storedEvent)
    {
        
        $stored = $this->serializer->deserialize($storedEvent->eventBody(), $storedEvent->typeName(), 'json');
        
        $this->messaging->publish($storedEvent->eventBody(), "", [
            'type' => $storedEvent->typeName(),
            'id' => $storedEvent->eventId(),
            'occurredOn' => $storedEvent->occurredOn()
        ]);
        
        $this->log->debug(sprintf('Producer je poslao tip "%s" u queue .', $storedEvent->typeName()), []);
        
        return $storedEvent;
    }

}
