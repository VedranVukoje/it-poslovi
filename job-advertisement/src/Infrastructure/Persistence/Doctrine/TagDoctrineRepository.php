<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use JobAd\Domain\Model\Tag\Tag;
use JobAd\Domain\Model\Tag\Id;
use JobAd\Domain\Model\Tag\TagRepository;
use JobAd\Domain\Model\Tag\Adapter\TagCollection;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\Tag\DoctrineTag;

/**
 * Description of TagDoctrineRepository
 *
 * @author vedran
 */
class TagDoctrineRepository implements TagRepository
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function nextIdentity()
    {
        return Id::generate();
    }

    public function ofId(Id $id): Tag
    {
        return $this->em->find(DoctrineTag::class, (string)$id);
    }

    public function add(Tag $tag)
    {
        $this->em->persist($tag);
    }

    public function query($specification)
    {
        return $specification->specifies($this);
    }
    
    public function readDataByDQL(string $dql, array $params = [])
    {
//        dump($params);
        
        $query = $this->em->createQuery($dql)->setParameters($params);

        return new TagCollection($query->getResult());
    }

}
