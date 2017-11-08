<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;

use JobAd\Domain\Model\JobAdvertisement\Assembler;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
/**
 * Description of DraftResponse
 * 
 * 
 * 
 * @author vedran
 */
class DraftResponse implements Assembler
{
    public $id;
    public $pozitonTitle;
    public $categoryes = [];
    public $typeOfJobs;
    public $description;
    public $howToApply;
    public $city;
    
    
    
    public function assemble(JobAdvertisement $jobAdvertisement)
    {
        
        
        dump($jobAdvertisement->toArray());
        
        $this->id = (string) $jobAdvertisement->id();
        $this->pozitonTitle = ($jobAdvertisement->pozitonTitle());
        $this->description = (string) $jobAdvertisement->description();
        $this->howToApply = (string) $jobAdvertisement->howToApply();
        $this->city[] =  (string)$jobAdvertisement->city()->postCode();
        
        $this->typeOfJobs = $jobAdvertisement->typeOfJobs()->toArray();
        $this->categoryes = $jobAdvertisement->categoryes()->toArray();
        
        return $this;
    }

    
    /**
     * @todo ne treba.. samo da je nisam zaboravio negde ...
     * @return 
     */
    public function toArray()
    {   
        return get_object_vars($this);
    }
}

