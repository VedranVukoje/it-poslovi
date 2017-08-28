<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\InMemory;


use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobSpecificationFactory;


/**
 * Description of TypeOfJobInMemorySpecification
 *
 * @author vedran
 */
class TypeOfJobInMemorySpecificationFactory implements TypeOfJobSpecificationFactory
{
    
    public function typeOfJobNameIsUniqu(TypeOfJob $typeOfJob)
    {
        return new TypeOfJobNameIsUniqu($typeOfJob);
    }
}
