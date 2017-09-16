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
use JobAd\Domain\Model\Tag\TagRepository;
use JobAd\Infrastructure\Persistence\Doctrine\Specification\TagByArrayIds;
/**
 * Description of JobAdManageTags
 *
 * @author vedran
 */
class JobAdManageTags implements ApplicationService
{
    private $appService;
    private $jobAdRepo;
    private $tagRepo;
    
    public function __construct(ApplicationService $appService, JobAdvertisementRepository $jobAdRepo, TagRepository $tagRepo)
    {
        $this->appService = $appService;
        $this->jobAdRepo = $jobAdRepo;
        $this->tagRepo = $tagRepo;
    }
    
    public function execute($request = null)
    {
        //        dump($request->tags);
        $appService = $this->appService->execute($request);
        $jobAd = $this->jobAdRepo->ofId(Id::fromNative($appService->get('jobAdId')));
        /**
         * @todo
         * ovo ubaciti u try catch exception.. npr za Doctrine ovde ce baciti Optimistic Lock Exception....
         */
        $this->jobAdRepo->lock($jobAd, (int) $jobAd->version());
        
        
        $tags = $this->tagRepo->query(new TagByArrayIds($request->tags));
        $jobAd->manageTags($tags);
        
//        dump($jobAd);
        
        $this->jobAdRepo->add($jobAd);
        
//        dump($jobAd);
//        dump($appService);
//        dump('Tagovi');
        
        return $appService;
    }
}
