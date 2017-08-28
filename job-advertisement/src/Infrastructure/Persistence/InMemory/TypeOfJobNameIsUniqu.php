<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\InMemory;

use JobAd\Domain\Model\TypeOfJob\TypeOfJobSpecification;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;

/**
 * Description of TypeOfJobName
 * TypeOfJobNameIsUniqu
 * @author vedran
 */
class TypeOfJobNameIsUniqu implements TypeOfJobSpecification
{
    private $typeOfJob;
    
    public function __construct(TypeOfJob $typeOfJob)
    {
        $this->typeOfJob = $typeOfJob;
    }
    
    public function specifies(TypeOfJob $typeOfJob)
    {
        return $this->typeOfJob->name() == $typeOfJob->name();
    }
}
