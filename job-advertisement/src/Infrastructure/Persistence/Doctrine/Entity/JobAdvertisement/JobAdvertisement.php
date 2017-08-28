<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\JobAdvertisement;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement as Base;
use JobAd\Domain\Model\JobAdvertisement\Id;

/**
 * Description of JobAdvertisement
 *
 * @author vedran
 */
class JobAdvertisement extends Base
{
    
    public function __construct(Id $id)
    {
        parent::__construct($id);
    }
}
