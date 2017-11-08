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
 * Description of JobAdvertisementAssemble
 * 
 * JobAd\Application\Service\JobAdvertisement\JobAdvertisementAssemble
 * 
 * @author vedran
 */
class JobAdvertisementFormResponse implements Assembler
{

    public $id;
    public $version;
    public $pozitonTitle;
    public $description;
    public $howToApply;
    public $categoryes;
    public $typeOfJobs;
    public $city;
//    public $start;
    public $end;
    public $tags;

    public function assemble(JobAdvertisement $jobAdvertisement)
    {
        
//        dump($jobAdvertisement);
        
        $this->id = (string) $jobAdvertisement->id();
        $this->version = $jobAdvertisement->version();
        $this->pozitonTitle = (string) $jobAdvertisement->pozitonTitle();
        $this->description = (string) $jobAdvertisement->description();
        $this->howToApply = (string) $jobAdvertisement->howToApply();
//        dump($this->categoryes);
        $this->categoryes = iterator_to_array($jobAdvertisement->categoryes()->map(function($category){
            return ['id' => (string) $category->id(), 'name' => (string) $category->name()];
        }));
//        dump($this->categoryes);
        $this->typeOfJobs = iterator_to_array($jobAdvertisement->typeOfJobs()->map(function($typeOfJob){
                return ['id' => (string) $typeOfJob->id(), 'name' => (string) $typeOfJob->name()];
            }));
        $this->city = [
            'name' => (string) $jobAdvertisement->city(),
            'postCode' => (string) $jobAdvertisement->city()->postCode()
        ];
        
        $this->tags = iterator_to_array($jobAdvertisement->tags()->map(function($tag){
            return ['id' => (string) $tag->id(), 'name' => (string) $tag->name(), 'slug' => $tag->slug()];
        }));
        
        $this->end = $jobAdvertisement->duration()->format('d.m.Y');
        
        return $this;
    }
    
}
