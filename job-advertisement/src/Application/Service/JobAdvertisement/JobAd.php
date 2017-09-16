<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;

//use JobAd\Application\Service\ApplicationService;
use JobAd\Domain\Model\JobAdvertisement\RepositoryFactory;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Infrastructure\Persistence\Doctrine\Specification\CategoryByArrayOfCategoryIds;
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;
use JobAd\Infrastructure\Persistence\Doctrine\Specification\CityByPostCodes;
use JobAd\Domain\Model\Location\Adapter\CityCollection;
use JobAd\Infrastructure\Persistence\Doctrine\Specification\TagByArrayIds;
use JobAd\Infrastructure\Persistence\Doctrine\Specification\TypeOfJobByArrayIds;
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;

/**
 * Description of JobAd
 *
 * @author vedran
 */
abstract class JobAd
{

    protected $repoFactory;

    public function __construct(RepositoryFactory $repoFactory)
    {
        $this->repoFactory = $repoFactory;
    }

    protected function ofId(Id $id)
    {
        return $this->repoFactory->jobAdRepo()->ofId($id);
    }

    protected function lock(Id $id, int $version)
    {
        return $this->repoFactory->jobAdRepo()->lock($id, $version);
    }

    protected function categoryByArrayOfCategoryIds(array $categoryes): CategoryCollection
    {
        return $this->repoFactory
                        ->categoryRepo()
                        ->query(new CategoryByArrayOfCategoryIds(array_map(function($category) {
                                    return $category['id'];
                                }, $categoryes ?? [])));
    }

    protected function cityesByPostCodes($postCode): CityCollection
    {
        return $this->repoFactory
                        ->cityRepo()
                        ->query(new CityByPostCodes($postCode));
        ;
    }

    protected function tagByArrayIds(array $tags)
    {
        return $this->repoFactory
                        ->tagRepo()
                        ->query(new TagByArrayIds($tags));
    }

    protected function typeOfJobByArrayIds(array $typeOfJobs): TypeOfJobCollection
    {
        return $this->repoFactory
                        ->typeOfJob()
                        ->query(new TypeOfJobByArrayIds(array_map(function ($ypeOfJob) {
                                    return $ypeOfJob['id'];
                                }, $typeOfJobs)));
    }

}
