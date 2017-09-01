<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\InMemory;

use JobAd\Domain\Model\JobAdvertisement\Adapter\JobAdvertisementCollection;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Id;

/**
 * Description of InMemoryJobAdvertisementRepo
 * JobAd\Infrastructure\Persistence\InMemory\InMemoryJobAdvertisementRepo
 * @author vedran
 */
class InMemoryJobAdvertisementRepo implements JobAdvertisementRepository
{

    private $data;

    public function __construct()
    {
        $this->data = new JobAdvertisementCollection();
    }
    
    public function ofId(Id $id): JobAdvertisement
    {
        ;
    }


    public function nextIdentity()
    {
        return Id::generate();
    }

    public function add(JobAdvertisement $jobAdvertisement)
    {
        $this->data[] = $jobAdvertisement;
    }

    public function query($specification)
    {
        
    }

}
