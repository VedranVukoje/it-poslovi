<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch\Listeners;

use Psr\Log\LoggerInterface;
use JobAd\Domain\EventSubscriber;
use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
//use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
/**
 * Description of CityWasAddedToJobAdvertisement
 *
 * @author vedran
 */
class CityWasAddedToJobAdvertisement implements EventSubscriber
{
    private $es;
    private $log;

    public function __construct(JobAdvertisementRepository $es, LoggerInterface $log)
    {
        $this->es = $es;
        $this->log = $log;
    }
    
    public function isSubscribedTo(DomainEvent $event)
    {
        return \JobAd\Domain\Model\JobAdvertisement\Events\CityWasAddedToJobAdvertisement::class === get_class($event);
    }
    
    public function handle(DomainEvent $event)
    {
        
        $this->log->debug('City Event', ['event' => $event]);
        
        $this->log->debug('PostCode', ['postCode' => $event->city()->postCode()]);
        
        $jobAd = $this->es->ofId($event->id());
        $jobAd->doApplayByDomainEvent($event);
        
        $this->es->add($jobAd);
    }
}
