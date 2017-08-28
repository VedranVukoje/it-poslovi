<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Specification;

use JobAd\Domain\SpecificationFactory;
/**
 * Description of TypeOfJobSepcificationFactory
 *
 * @author vedran
 */
class TypeOfJobSepcificationFactory implements SpecificationFactory
{
    public function typeOfJobByArrayIds($ids)
    {
        return new TypeOfJobByArrayIds($ids);
    }
}
