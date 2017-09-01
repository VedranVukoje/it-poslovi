<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\EventStore;

/**
 * Description of EventStoreJobAdRepository
 *
 * @author vedran
 */
class EventStoreJobAdRepository implements JobAdvertisementRepository
{

    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function nextIdentity()
    {
        ;
    }

    public function ofId(Id $id)
    {
        ;
    }

    public function query($specification)
    {
        ;
    }

    public function add(JobAdvertisement $jobAdvertisement)
    {
//        $this->eventStore->append($domainEvent);
    }

}
