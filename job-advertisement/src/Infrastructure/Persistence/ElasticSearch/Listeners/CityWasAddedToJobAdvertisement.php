<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch\Listeners;

use JobAd\Domain\EventSubscriber;
use JobAd\Domain\DomainEvent;
use JobAd\Infrastructure\Persistence\ElasticSearch\EsJobAdvertisementRepository;
/**
 * Description of CityWasAddedToJobAdvertisement
 *
 * @author vedran
 */
class CityWasAddedToJobAdvertisement implements EventSubscriber
{
    private $es;

    public function __construct(EsJobAdvertisementRepository $es)
    {
        $this->es = $es;
    }
    
    public function isSubscribedTo(DomainEvent $event)
    {
        return \JobAd\Domain\Model\JobAdvertisement\Events\CityWasAddedToJobAdvertisement::class === get_class($event);
    }
    
    public function handle(DomainEvent $event)
    {
        $id = $event->id();
        $occurredOn = $event->occurredOn();
        $event->city();
    }
}