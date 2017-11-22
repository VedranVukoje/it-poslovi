<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Category;

/**
 * Description of CategoryHydrator
 *
 * @author vedran
 */
class CategoryHydrator extends Category implements CategoryHydratorInterface
{
    public function extract(Category $category): array
    {
        return [
            'id' => (string) $category->id,
            'name' => $category->name
        ];
    }
    
    public function hydrate(array $data, Category $category): Category
    {
        
        $category->name = new Name($data['name']);
        
        return $category;
    }
    
    
}
