<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\LockMode;
/**
 * @todo...OptimisticLockException
 */
//use Doctrine\ORM\OptimisticLockException;
//use Doctrine\Common\Collections\ArrayCollection;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\JobAdvertisement\DoctreineJobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Id;

/**
 * Description of DoctrineJobAdvertisementRepository
 * 
 * @author vedran
 */
class DoctrineJobAdvertisementRepository implements JobAdvertisementRepository
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function ofId(Id $id): JobAdvertisement
    {
//        $id = (string)$id;
//        dump($id);
        return $this->em->find(DoctreineJobAdvertisement::class, (string) $id);
    }
    
    public function lock(JobAdvertisement $jobAd, int $version)
    {
        return $this->em->lock($jobAd, LockMode::OPTIMISTIC, $version);
    }

    public function nextIdentity()
    {
        return Id::generate();
    }

    public function add(JobAdvertisement $jobAdvertisement)
    {

//        $this->em->merge($jobAdvertisement);
        $this->em->persist($jobAdvertisement);

//        $metaDataClass = $this->em->getClassMetadata(JobAdvertisement::class);
//        $this->em->getUnitOfWork()->recomputeSingleEntityChangeSet($metaDataClass, $jobAdvertisement);
    }

    public function query($specification)
    {

        $query = $this->em->getRepository(JobAdvertisement::class)->matching($specification);

        return $query;
    }

}
