<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\Category;

use JobAd\Domain\Model\Category\Category;
use JobAd\Domain\Model\Category\Id;
/**
 * Description of DoctrineCategory
 * Category.DoctrineCategory.orm
 * JobAd\Infrastructure\Persistence\Doctrine\Entity\Category\DoctrineCategory
 * @author vedran
 */
class DoctrineCategory extends Category
{
    public function __construct(Id $id)
    {
        parent::__construct($id);
    }
}
