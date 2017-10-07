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
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\RepositoryFactory;
/**
 * Description of JobAdDescriptionsWasManaged
 *
 * @author vedran
 */
class JobAdDescriptionsWasManaged implements EventSubscriber
{
    
    private $es;
    private $repoFactory;

    public function __construct(JobAdvertisementRepository $es, RepositoryFactory $repoFactory)
    {
        $this->es = $es;
        $this->repoFactory = $repoFactory;
    }
    
    public function isSubscribedTo(DomainEvent $event)
    {
        return \JobAd\Domain\Model\JobAdvertisement\Events\JobAdDescriptionsWasManaged::class === get_class($event);
    }
    
    public function handle(DomainEvent $event)
    {
        $jobAd = $this->es->ofId($event->id());
        $jobAd->doApplayByDomainEvent($event);
        
        $this->es->add($jobAd);
    }
}
