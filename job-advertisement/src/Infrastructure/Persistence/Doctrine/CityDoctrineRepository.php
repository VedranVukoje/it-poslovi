<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use JobAd\Domain\Collection;
use JobAd\Domain\Model\Location\Adapter\CityCollection;
use JobAd\Domain\Model\Location\CityRepository;
//use JobAd\Domain\Model\Location\
use JobAd\Domain\Model\Location\City;
use JobAd\Domain\Model\Location\PostCode;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\Location\DoctrineCity;
/**
 * Description of CityRepository
 * JobAd\Infrastructure\Persistence\Doctrine\CityDoctrineRepository
 * @author vedran
 */
class CityDoctrineRepository implements CityRepository
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function byPostCode(PostCode $postcode): City
    {
        return $this->em->find(DoctrineCity::class, (string)$postcode);
    }
    
    public function query($specification): Collection
    {
        return $specification->specifies($this);
    }
    
    /**
     * 
     * @param string $dql
     * @param array $params
     * @return City[]
     */
    public function readDataByDQL(string $dql, array $params = [])
    {
        $query = $this->em->createQuery($dql)->setParameters($params)->getResult();
        
        return new CityCollection($query);
    }
    
}
