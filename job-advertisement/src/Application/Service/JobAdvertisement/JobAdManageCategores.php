<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;

use JobAd\Application\Service\ApplicationService;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\Category\CategoryRepository;
use JobAd\Domain\Model\Category\Exceptions\CategoresNotFoundException;
use JobAd\Infrastructure\Persistence\Doctrine\Specification\CategoryByArrayOfCategoryIds;
use JobAd\Domain\Model\JobAdvertisement\Id;

/**
 * Description of JobAdManageCategores
 *
 * @author vedran
 */
class JobAdManageCategores implements ApplicationService
{

    private $appService;
    private $jobAdRepo;
    private $categoryRepo;

    public function __construct(ApplicationService $appService, JobAdvertisementRepository $jobAdRepo, CategoryRepository $categoryRepo)
    {
        $this->appService = $appService;
        $this->jobAdRepo = $jobAdRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function execute($request = null)
    {
//        dump($request);

        $spec = new CategoryByArrayOfCategoryIds(array_map(function($category) {
                    return $category['id'];
                }, $request->categoryes ?? []));

        $categoryes = $this->categoryRepo->query($spec);

        if (0 == count($categoryes)) {
            throw new CategoresNotFoundException("Niste izabrali kategoriju.");
        }

        $appService = $this->appService->execute($request);



        $jobAd = $this->jobAdRepo->ofId(Id::fromNative($appService->get('jobAdId')));
        /**
         * @todo
         * ovo ubaciti u try catch exception.. npr za Doctrine ovde ce baciti Optimistic Lock Exception....
         */
        $this->jobAdRepo->lock($jobAd, (int) $jobAd->version());
        $jobAd->manageCategores($categoryes);
//        dump($jobAd);

        $this->jobAdRepo->add($jobAd);

//        dump($jobAd);
//        dump($appService);
//        dump('kategorije');
        return $appService;
    }

}
