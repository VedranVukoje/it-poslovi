<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Specification;

use JobAd\Domain\SpecificationFactory;
/**
 * Description of CitySpecificationFactory
 * 
 * JobAd\Infrastructure\Persistence\Doctrine\Specification\CitySpecificationFactory
 * @author vedran
 */
class CitySpecificationFactory implements SpecificationFactory
{
    
    public function cityByPostCodes($postCode)
    {
        return new CityByPostCodes($postCode);
    }
}
