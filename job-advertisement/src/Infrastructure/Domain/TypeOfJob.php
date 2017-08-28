<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Domain;

use JobAd\Domain\Model\TypeOfJob\FactoryTypeOfJob;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob as DomainTypeOfJob;
use JobAd\Domain\Model\TypeOfJob\Name;
/**
 * Description of FactoryTypeOfJob
 *
 * 
 * @todo prebaci u domen ovaj factory.
 * 
 * @author vedran
 */
class TypeOfJob implements FactoryTypeOfJob
{
    public function writeNewTypeOfJob(Name $name)
    {
        return DomainTypeOfJob::writeNewTypeOfJob($name);
    }
}
