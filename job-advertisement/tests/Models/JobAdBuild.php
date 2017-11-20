<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Tests\Models;

use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\Category\Category;
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;

/**
 * Description of JobAdBuild
 * 
 * 
 * @author vedran
 */
class JobAdBuild
{

    private $id;
    private $pozitonTitle;
    private $description;
    private $howToApplay;
    private $categoryes = [];
    private $postCode;
    private $city;
    private $isDrafted = false;

    public static function create(): self
    {
        return new static(Id::generate());
    }

    public function withDescription(string $pozitonTitle, string $description, string $howToApplay)
    {
        $this->pozitonTitle = $pozitonTitle;
        $this->description = $description;
        $this->howToApplay = $howToApplay;

        return $this;
    }
    
    public function withThisCategoryes(array $categoryes)
    {
        $this->setCategoryes($categoryes);
        return $this;
    }

    public function whoIsDrafted()
    {
        $this->isDrafted = true;
        return $this;
    }

    public function withCity(int $postCode, string $city)
    {
        $this->postCode = $postCode;
        $this->city = $city;

        return $this;
    }

    public function build()
    {
        $jobAd = new JobAdvertisement($this->id);
        
        $jobAd->changeStatusToDraft();
        
        $jobAd->manageJobAdDescriptions($this->pozitonTitle, $this->description, $this->howToApplay);
        
        $jobAd->manageCategores($this->categoryes);

        $jobAd->addCity($this->postCode, $this->city);

        return $jobAd;
    }

    private function __construct($id)
    {
        $this->id = $id;
    }
    
    private function setCategoryes(array $categoryes)
    {
        $this->categoryes = new CategoryCollection(array_map(function($id, $name){
            return Category::fromNative($id, $name);
        }, array_keys($categoryes) ,$categoryes));
    }

}
