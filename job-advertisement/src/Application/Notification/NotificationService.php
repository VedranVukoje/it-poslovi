<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Notification;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement as JobAd;
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

    public function __construct(
    EventStore $eventStore, PublishedMessageTracker $publishedMessageTracker, Serializer $serializer)
    {
        $this->eventStore = $eventStore;
        $this->publishedMessageTracker = $publishedMessageTracker;
        $this->serializer = $serializer;
    }

    public function publishNotifications(string $exchangeName)
    {

        $publishedMessageTracker = $this->publishedMessageTracker();
        $trackId = $publishedMessageTracker->mostRecentPublishedMessageId($exchangeName);
        
        $notifications = $this->listUnpublishedNotifications((int)$trackId);
        
        dump($notifications);
        
        $history = [];
        foreach ($notifications as $notifications){
            $history[] = $this->serializer->deserialize($notifications->eventBody(), $notifications->typeName(), 'json');
        }
        
        dump($history);
        
//        foreach ($history as $h){
//            dump((string)$h->id());
//        }
        
    }

    private function publishedMessageTracker()
    {
        return $this->publishedMessageTracker;
    }

    private function listUnpublishedNotifications($mostRecentPublishedMessageId)
    {
        return $this->eventStore->allStoredEventsSince($mostRecentPublishedMessageId);
    }

}
