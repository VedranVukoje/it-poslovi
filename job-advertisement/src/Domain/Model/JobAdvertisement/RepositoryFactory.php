<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement;

/**
 *
 * @author vedran
 */
interface RepositoryFactory
{

    public function jobAdRepo(): JobAdvertisementRepository;
    
    public function categoryRepo();
    
    public function cityRepo();
    
    public function tagRepo();
    
    public function typeOfJob();
}
