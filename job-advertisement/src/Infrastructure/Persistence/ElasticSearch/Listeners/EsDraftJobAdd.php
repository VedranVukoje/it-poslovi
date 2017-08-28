<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch\Listeners;

use JobAd\Domain\EventSubscriber;
use JobAd\Domain\DomainEvent;

use JobAd\Domain\Model\JobAdvertisement\JobAddIsDrafted;
use JobAd\Infrastructure\Persistence\ElasticSearch\EsJobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
/**
 * Description of EsDraftJobAdd
 *
 * @author vedran
 */
class EsDraftJobAdd implements EventSubscriber
{
    
    private $repo;
    
    private $esRepo;
    
    public function __construct(EsJobAdvertisementRepository $esRepo, JobAdvertisementRepository $repo)
    {
        $this->esRepo = $esRepo;
        $this->repo = $repo;
    }
    
    /**
     * 
     * @param DomainEvent $event
     * @return bool
     */
    public function isSubscribedTo(DomainEvent $event)
    {
        return get_class($event) == JobAddIsDrafted::class;
    }
    
    /**
     * 
     * @param DomainEvent $event
     * @todo Ubaciti log.
     */
    public function handle(DomainEvent $event)
    {
        if($draft = $this->repo->byId($event->id())){
            dump('tu sam ...');
            $this->esRepo->add($draft);
        }
    }
}
