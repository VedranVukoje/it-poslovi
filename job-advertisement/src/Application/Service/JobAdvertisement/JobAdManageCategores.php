<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;

use Psr\Log\LoggerInterface;
use JobAd\Application\Service\ApplicationService;
//use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
//use JobAd\Domain\Model\Category\CategoryRepository;
use JobAd\Domain\Model\Category\Exceptions\CategoresNotFoundException;
//use JobAd\Infrastructure\Persistence\Doctrine\Specification\CategoryByArrayOfCategoryIds;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\JobAdvertisement\RepositoryFactory;

/**
 * Description of JobAdManageCategores
 *
 * @author vedran
 */
class JobAdManageCategores extends JobAd implements ApplicationService
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
        
        $categoryes = $this->categoryByArrayOfCategoryIds($request->categoryes);

        if (0 == count($categoryes)) {
            throw new CategoresNotFoundException("Niste izabrali kategoriju.");
        }

        $jobAd = $this->ofId($id);
        /**
         * @todo
         * ovo ubaciti u try catch exception.. npr za Doctrine ovde ce baciti Optimistic Lock Exception....
         */
        $this->lock($jobAd, (int) $jobAd->version());
        
        $jobAd->manageCategores($categoryes);

        $this->repoFactory->jobAdRepo()->add($jobAd);

        $request->version = (int) $jobAd->version();
        $this->logger->debug('Categoryes are managed ', ['jobAd' => $this->extract($jobAd)]);
        return $appService;
    }

}
