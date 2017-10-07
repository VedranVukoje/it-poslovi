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
//use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
//use JobAd\Infrastructure\Persistence\Doctrine\Specification\TypeOfJobByArrayIds;
//use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\Category\Exceptions\TypeOfJobNotFoundException;
use JobAd\Domain\Model\JobAdvertisement\RepositoryFactory;

/**
 * Description of JobAdManageTypeOfJobs
 *
 * @author vedran
 */
class JobAdManageTypeOfJobs extends JobAd implements ApplicationService
{

    protected $appService;
    private $logger;

    public function __construct(ApplicationService $appService, RepositoryFactory $repoFactory, LoggerInterface $logger)
    {
        $this->appService = $appService;
        $this->logger = $logger;

        parent::__construct($repoFactory);
    }

    public function execute($request = null)
    {
        
        $typeOfJobs = $this->typeOfJobByArrayIds($request->typeOfJobs);
        
        $appService = $this->appService->execute($request);
        $id = $appService->get('id');

        if (0 == count($typeOfJobs)) {
            throw new TypeOfJobNotFoundException("Morate izabrati makar jedan tip posla");
        }

        $jobAd = $this->ofId($id);
        /**
         * @todo
         * ovo ubaciti u try catch exception.. npr za Doctrine ovde ce baciti Optimistic Lock Exception....
         */
        $this->lock($jobAd, (int) $jobAd->version());
        $jobAd->manageTypeOfJobs($typeOfJobs);

        $this->repoFactory->jobAdRepo()->add($jobAd);
        
        $request->version = (int) $jobAd->version();
        $this->logger->debug('Type of jobs are added to Job Ad', ['jobAd' => $this->extract($jobAd)]);
        
        return $appService;
    }

}
