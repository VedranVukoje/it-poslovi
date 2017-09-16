<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;

use JobAd\Application\Service\ApplicationService;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
use JobAd\Infrastructure\Persistence\Doctrine\Specification\TypeOfJobByArrayIds;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\Category\Exceptions\TypeOfJobNotFoundException;

/**
 * Description of JobAdManageTypeOfJobs
 *
 * @author vedran
 */
class JobAdManageTypeOfJobs implements ApplicationService
{
    protected $appService;
    private $jobAdRepo;
    private $typeOfJobRepo;

    public function __construct(ApplicationService $appService, JobAdvertisementRepository $jobAdRepo, TypeOfJobRepository $typeOfJobRepo)
    {
        $this->appService = $appService;
        $this->jobAdRepo = $jobAdRepo;
        $this->typeOfJobRepo = $typeOfJobRepo;
    }
    
    public function execute($request = null)
    {
        $typeOfJobs = $this->typeOfJobRepo->query(new TypeOfJobByArrayIds(array_map(function ($ypeOfJob) {
                    return $ypeOfJob['id'];
                }, $request->typeOfJobs)));
                
        if(0 == count($typeOfJobs)){
            throw new TypeOfJobNotFoundException("Morate izabrati makar jedan tip posla");
        }
        
        $appService = $this->appService->execute($request);
        
        $jobAd = $this->jobAdRepo->ofId(Id::fromNative($appService->get('jobAdId')));
        /**
         * @todo
         * ovo ubaciti u try catch exception.. npr za Doctrine ovde ce baciti Optimistic Lock Exception....
         */
        $this->jobAdRepo->lock($jobAd, (int) $jobAd->version());
        $jobAd->manageTypeOfJobs($typeOfJobs);
        
        $this->jobAdRepo->add($jobAd);
        
//        dump($jobAd);
//        dump($appService);
//        dump('Tipovi posla');
        
        return $appService;
    }
}
