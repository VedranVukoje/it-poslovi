<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Specification;

use JobAd\Domain\Model\Location\City;
use JobAd\Domain\Model\Location\CityRepository;
use JobAd\Domain\Model\Location\CitySpecification;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\Location\DoctrineCity;
/**
 * Description of CityByPostCodes
 *
 * @author vedran
 */
class CityByPostCodes implements CitySpecification
{
    
    private $postCode;
    
    public function __construct($postCode)
    {
        $this->postCode = $postCode;
    }

    public function specifies(CityRepository $repo)
    {
        $dql = "SELECT c FROM ".DoctrineCity::class." c WHERE c.postCode = :postCode ";
        
        return $repo->readDataByDQL($dql, ['postCode' => (int) $this->postCode]);
    }
}
