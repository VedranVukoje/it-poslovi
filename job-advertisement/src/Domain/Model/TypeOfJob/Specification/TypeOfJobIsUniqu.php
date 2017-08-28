<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\TypeOfJob\Specification;

use JobAd\Domain\Model\TypeOfJob\TypeOfJobSpecification;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
/**
 * Description of TypeOfJobNameIsUniqu
 *
 * @author vedran
 */
class TypeOfJobIsUniqu implements TypeOfJobSpecification
{
    
    private $typeOfJob;
    
    public function __construct(TypeOfJob $typeOfJob)
    {
        $this->typeOfJob = $typeOfJob;
    }


    public function specifies(TypeOfJobRepository $repo)
    {
        return $repo->nameIsUnique("SELECT "
                . "DISTINCT t.name FROM ".TypeOfJob::class." t "
                . "WHERE t.name = :name", [
                    'name' => (string)$this->typeOfJob->name()
                ]);
    }
}
