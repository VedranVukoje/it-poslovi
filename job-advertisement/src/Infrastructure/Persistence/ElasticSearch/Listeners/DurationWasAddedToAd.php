<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch\Listeners;

use JobAd\Domain\EventSubscriber;
use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
//use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
/**
 * Description of DurationWasAddedToAd
 *
 * @author vedran
 */
class DurationWasAddedToAd implements EventSubscriber
{
    private $es;

    public function __construct(JobAdvertisementRepository $es)
    {
        $this->es = $es;
    }
    
    public function isSubscribedTo(DomainEvent $event)
    {
        return \JobAd\Domain\Model\JobAdvertisement\Events\DurationWasAddedToAd::class === get_class($event);
    }
    
    public function handle(DomainEvent $event)
    {
        $jobAd = $this->es->ofId($event->id());
        $jobAd->doApplayByDomainEvent($event);
        
        $this->es->add($jobAd);
    }
}
