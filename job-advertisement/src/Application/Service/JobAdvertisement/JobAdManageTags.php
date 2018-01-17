<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;

use JobAd\Application\Service\ApplicationService;
use Psr\Log\LoggerInterface;
//use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
//use JobAd\Domain\Model\JobAdvertisement\Id;
//use JobAd\Domain\Model\Tag\TagRepository;
//use JobAd\Infrastructure\Persistence\Doctrine\Specification\TagByArrayIds;
use JobAd\Domain\Model\JobAdvertisement\RepositoryFactory;

/**
 * Description of JobAdManageTags
 *
 * @author vedran
 */
class JobAdManageTags extends JobAd implements ApplicationService
{

    private $appService;
    

    public function __construct(ApplicationService $appService, RepositoryFactory $repoFactory, LoggerInterface $logger)
    {
        $this->appService = $appService;
        $this->logger = $logger;
        parent::__construct($repoFactory,$logger);
    }

    public function execute($request = null)
    {
        
        $appService = $this->appService->execute($request);
        $id = $appService->get('id');
        
        $tags = $this->tagByArrayIds($request->tags);
        
        
        $jobAd = $this->ofId($id);
        /**
         * @todo
         * ovo ubaciti u try catch exception.. npr za Doctrine ovde ce baciti Optimistic Lock Exception....
         */
        $this->lock($jobAd, (int) $jobAd->version());

        $jobAd->manageTags($tags);

        $this->repoFactory->jobAdRepo()->add($jobAd);
        
        $request->version = (int) $jobAd->version();
        $this->logger->debug('Tags are added to Job Ad', ['jobAd' => $this->extract($jobAd)]);
        
        return $appService;
    }

}
