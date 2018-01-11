<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
//use InvalidArgumentException;
use JobAd\Domain\Collection;
use JobAd\Domain\Model\Category\CategoryRepository;
use JobAd\Domain\Model\Category\CategorySpecification;
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;
use JobAd\Domain\Model\Category\Category;
use JobAd\Domain\Model\Category\Id;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\Category\DoctrineCategory;

/**
 * Description of CategoryDoectrineRepository
 * 
 *  JobAd\Infrastructure\Persistence\Doctrine\CategoryDoectrineRepository
 *
 * @author vedran
 */
class CategoryDoectrineRepository implements CategoryRepository
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function nextIdentity()
    {
        
    }

    public function ofId(Id $id): Category
    {
        
    }

    public function add(Category $type_of_job)
    {
        
    }

    public function query(CategorySpecification $specification): Collection
    {
        return $specification->specifies($this);
    }
    
    public function queryByDql(string $dql, array $params = [])
    {
        $category = $this->em->createQuery($dql)->setParameters($params)->getResult();
        return new CategoryCollection($category);
    }

    public function byIds(array $ids = [])
    {
        $query = $this->em->createQueryBuilder('c')
                ->select('c')
                ->from(DoctrineCategory::class, 'c')
                ->andWhere('c.id IN (:ids)')
                ->setParameter('ids', $ids);

        return new CategoryCollection($query->getQuery()->getResult());
    }

}
