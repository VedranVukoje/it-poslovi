<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\TypeOfJob;

use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\TypeOfJob\Id;
/**
 * Description of DoctrineTypeOfJob
 *
 * JobAd\Infrastructure\Persistence\Doctrine\Entity\TypeOfJob\DoctrineTypeOfJob
 * TypeOfJob.DoctrineTypeOfJob.orm
 * @author vedran
 */
class DoctrineTypeOfJob extends TypeOfJob
{
    public function __construct(Id $id)
    {
        parent::__construct($id);
    }
}
