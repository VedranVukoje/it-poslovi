<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\TypeOfJob;

use JobAd\Domain\SpecificationFactory;
use JobAd\Application\Service\ApplicationService;
use JobAd\Application\Service\ServiceApplicationDecorator;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
use JobAd\Application\Service\TypeOfJob\ViewTypeOfJobArrayCollectionResponse;
use JobAd\Domain\Model\TypeOfJob\Id;

/**
 * Description of ViewTypeOfJobService
 *
 * @author vedran
 */
class ViewTypeOfJobService extends ServiceApplicationDecorator implements ApplicationService
{

    private $appService;
    private $repository;
    private $specification;

    public function __construct(ApplicationService $appService, TypeOfJobRepository $repository, SpecificationFactory $specification)
    {
        $this->appService = $appService;
        $this->repository = $repository;
        $this->specification = $specification;
    }

    /**
     * 
     * @important 
     * @todo 
     * Ako ti pukne ovde to je iz razloga sto sam ubacio specifikaciju
     * kada sam radio JobAd Model. U TypeJob modelu ubaci samo specifikacij.
     * 
     * @param type $request
     * @return type
     * @throws \Exception
     */
    public function execute($request = null)
    {

        $cpec = $this->specification->typeOfJobByArrayIds(array_map(function ($ypeOfJob) {
                    return $ypeOfJob['id'];
                }, $request->typeOfJobs));
        $typeOfJobs = $this->repository->query($cpec);

        $response = (new ViewTypeOfJobArrayCollectionResponse)->assemble($typeOfJobs)->typeOfJobs;
        return $this->appService->execute($request)->set('app.service.typeOfJob.typeOfJobs', $response);
    }

}
