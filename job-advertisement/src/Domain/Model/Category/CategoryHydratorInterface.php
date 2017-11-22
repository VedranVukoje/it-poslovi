<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Category;

/**
 *
 * @author vedran
 */
interface CategoryHydratorInterface
{
    public function extract(Category $category): array;
    public function hydrate(array $data, Category $category): Category;
}
