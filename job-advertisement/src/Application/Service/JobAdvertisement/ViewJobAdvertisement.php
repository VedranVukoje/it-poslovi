<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;


use JobAd\Application\Service\ApplicationService;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\Assembler;

/**
 * Description of ViewJobAdvertisement
 * 
 * @author vedran
 */
class ViewJobAdvertisement implements ApplicationService
{
    
    
    private $repo;
    
    private $assembler;

    
    public function __construct(JobAdvertisementRepository $repo, Assembler $assembler)
    {
        $this->repo = $repo;
        $this->assembler = $assembler;
    }

    public function execute($request = null)
    {
        $jobAd = $this->repo->ofId(Id::fromNative($request->id));
        
        return $this->assembler->assemble($jobAd);
    }
    
}
