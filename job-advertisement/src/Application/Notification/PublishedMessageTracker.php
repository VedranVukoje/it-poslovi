<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Notification;

use JobAd\Domain\Event\StoredEvent;
/**
 *
 * @author vedran
 */
interface PublishedMessageTracker
{

    /**
     * @param string $exchangeName
     * @return int
     */
    public function mostRecentPublishedMessageId(string $exchangeName);

    /**
     * @param string $exchangeName
     * @param StoredEvent $notification
     */
    public function trackMostRecentPublishedMessage(string $exchangeName, StoredEvent $notification);
}
