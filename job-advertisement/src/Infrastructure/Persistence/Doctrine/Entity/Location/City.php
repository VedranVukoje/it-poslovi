<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\Location;

use JobAd\Domain\Model\Location\City as Domain;
use JobAd\Domain\Model\Location\PostCode;
/**
 * Description of City
 *
 * @author vedran
 */
class City extends Domain
{
    public function __construct(PostCode $postCode, string $city)
    {
        parent::__construct($postCode, $city);
    }
}
