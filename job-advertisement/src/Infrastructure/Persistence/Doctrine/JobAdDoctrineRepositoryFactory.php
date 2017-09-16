<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use JobAd\Domain\Model\JobAdvertisement\RepositoryFactory;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
/**
 * Description of JobAdDoctrineFactoryRepository
 * 
 * @author vedran
 */
class JobAdDoctrineRepositoryFactory implements RepositoryFactory
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    
    public function jobAdRepo(): JobAdvertisementRepository
    {
        return new DoctrineJobAdvertisementRepository($this->em);
    }
    
    public function categoryRepo()
    {
        return new CategoryDoectrineRepository($this->em);
    }
    
    public function cityRepo()
    {
        return new CityDoctrineRepository($this->em);
    }
    
    public function tagRepo()
    {
        return new TagDoctrineRepository($this->em);
    }
    
    public function typeOfJob()
    {
        return new TypeOfJobDoctrineRepository($this->em);
    }
}
