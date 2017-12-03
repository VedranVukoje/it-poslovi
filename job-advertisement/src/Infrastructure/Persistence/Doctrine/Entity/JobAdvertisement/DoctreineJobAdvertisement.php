<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\JobAdvertisement;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;

/**
 * Description of JobAdvertisement
 * /home/vedran/Projects/dev/projects/it-poslovi/job-advertisement/src/Infrastructure/Persistence/Doctrine/Entity/JobAdvertisement/DoctreineJobAdvertisement.php
 * JobAd\Infrastructure\Persistence\Doctrine\Entity\JobAdvertisement\DoctreineJobAdvertisement
 * JobAdvertisement.DoctreineJobAdvertisement.orm
 * @author vedran
 */
class DoctreineJobAdvertisement extends JobAdvertisement
{

    private $surrogateCategoryes;

    public function __construct(Id $id)
    {
        parent::__construct($id);
    }

    public function manageCategores(CategoryCollection $new)
    {

        foreach ($new as $category) {
            if (!$this->categoryes->contains($category)) {
                $this->addCategory((string) $category->id(), (string) $category->name());
            }
        }

        foreach ($this->categoryes as $category) {
            if (!$new->contains($category)) {
                $this->removeCategory((string) $category->id());
            }
        }
        
        $this->surrogateCategoryes = $this->categoryes;
    }
    
    

}
