<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Specification;

use JobAd\Domain\Model\Category\Category;
use JobAd\Domain\Model\Category\CategorySpecification;
use JobAd\Domain\Model\Category\CategoryRepository;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\Category\DoctrineCategory;

/**
 * Description of CategoryByArrayOfCategoryIds
 *
 * @author vedran
 */
class CategoryByArrayOfCategoryIds implements CategorySpecification
{

    private $ids = [];

    public function __construct(array $ids = [])
    {
        $this->setIds($ids);
    }

    public function specifies(CategoryRepository $repo)
    {
        
        $dql = "SELECT c FROM ".DoctrineCategory::class." c WHERE c.id IN (".$this->ids.") ";
        
        return $repo->queryByDql($dql, []);
    }
    
    private function setIds(array $ids = [])
    {
        $this->ids = implode(',', array_map(function($id){
            return "'".$id."'";
        }, $ids));
    }

}
