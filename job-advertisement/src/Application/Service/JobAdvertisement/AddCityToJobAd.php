<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;

use JobAd\Application\Service\ApplicationService;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\Location\CityRepository;
use JobAd\Infrastructure\Persistence\Doctrine\Specification\CityByPostCodes;
use JobAd\Domain\Model\Location\Exception\CityNotFoundException;
use JobAd\Domain\Model\JobAdvertisement\Exceptions\OnlyOneCityPerJobAd;
use JobAd\Domain\Model\JobAdvertisement\RepositoryFactory;


/**
 * Description of AddCityToJobAd
 *
 * @author vedran
 */
class AddCityToJobAd extends JobAd implements ApplicationService
{
    
    protected $appService;


    public function __construct(ApplicationService $appService, RepositoryFactory $repoFactory, CityRepository $cityRepo)
    {
        $this->appService = $appService;
        
        parent::__construct($repoFactory);
            
    }

    public function execute($request = null)
    {
        $appService = $this->appService->execute($request);
        
        $cities = $this->cityRepo->query(new CityByPostCodes($request->city['postCode']));
        
        if (0 == count($cities)) {
            throw new CityNotFoundException(sprintf('Post Code "%s" ne postoji.', $request->city['postCode']));
        }
        
        if (1 !== count($cities)) {
            throw new OnlyOneCityPerJobAd("Samo jedan lokacija po oglasu.");
        }
        
        // jobAdId je JobAd\Domain\Model\JobAdvertisement\Id
        $jobAd = $this->jobAdRepo->ofId(Id::fromNative($appService->get('jobAdId')));
        /**
         * @todo
         * ovo ubaciti u try catch exception.. npr za Doctrine ovde ce baciti Optimistic Lock Exception....
         */
        $this->jobAdRepo->lock($jobAd, (int) $jobAd->version());
        
        $jobAd->addCity((string)$cities[0]->postCode(),(string)$cities[0]);
        
        $this->jobAdRepo->add($jobAd);
        
//        dump($jobAd);
//        dump('City.....');
        
        return $appService;
    }
}
