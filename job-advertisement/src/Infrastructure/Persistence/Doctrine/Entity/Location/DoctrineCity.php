<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\Location;

use JobAd\Domain\Model\Location\City;
use JobAd\Domain\Model\Location\PostCode;
/**
 * Description of DoctrineCity
 * JobAd\Infrastructure\Persistence\Doctrine\Entity\Location\DoctrineCity
 * Location.DoctrineCity.orm
 * @author vedran
 */
class DoctrineCity extends City
{
    public function __construct(PostCode $postCode, string $name)
    {
        parent::__construct($postCode, $name);
    }
}
