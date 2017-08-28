<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Specification;

use JobAd\Domain\Model\Category\CategorySpecificationFactory;
/**
 * Description of CategorySepecificationFactory
 *
 * @author vedran
 */
class CategorySepecificationFactory extends CategorySpecificationFactory
{
    public function categoryByArrayOfCategoryIds(array $ids = [])
    {
        return new CategoryByArrayOfCategoryIds($ids);
    }
}
