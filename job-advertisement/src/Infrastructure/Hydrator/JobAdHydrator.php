<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Hydrator;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementHydratorInterface;
use GeneratedHydrator\Configuration;
/**
 * Description of JobAdHydrator
 *
 * @author vedran
 */
class JobAdHydrator implements JobAdvertisementHydratorInterface
{
    
    private $hidrator;
    
    
    public function __construct()
    {
        $config = new Configuration(JobAdvertisement::class);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $this->hidrator = new $hydratorClass();
    }

    public function extract(JobAdvertisement $jobAd): array
    {
        return $this->hidrator->extract($jobAd);
    }
    
    public function hydrate(array $data, JobAdvertisement $jobAd): JobAdvertisement
    {
        return $this->hidrator->hydrate($data, $jobAd);
    }
}
