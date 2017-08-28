<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\TypeOfJob\Specification;


use JobAd\Domain\Model\TypeOfJob\TypeOfJobSpecification;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;

/**
 * Description of TypeOfJobByArrayIds
 *
 * @author vedran
 */
class TypeOfJobByArrayIds implements TypeOfJobSpecification
{
    
    private $ids = [];
    
    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    

    public function specifies(TypeOfJobRepository $repo)
    {
        $repo->readDataByDQL();
    }
}
