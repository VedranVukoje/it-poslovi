<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch\Listeners;


use JobAd\Domain\EventSubscriber;
use JobAd\Domain\DomainEvent;
//use JobAd\Infrastructure\Persistence\ElasticSearch\EsJobAdvertisementRepository;
//use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;

/**
 * Description of TypeOfJobWasAddedToJobAd
 *
 * @author vedran
 */
class TypeOfJobWasAddedToJobAd implements EventSubscriber
{
    
    private $es;

    public function __construct(JobAdvertisementRepository $es)
    {
        $this->es = $es;
    }
    
    public function isSubscribedTo(DomainEvent $event)
    {
        return \JobAd\Domain\Model\JobAdvertisement\Events\TypeOfJobWasAddedToJobAd::class == get_class($event); 
    }
    
    public function handle(DomainEvent $event)
    {
        $jobAd = $this->es->ofId(Id::fromNative($event->id()));
        $jobAd->doApplayByDomainEvent($event);
    }
}
