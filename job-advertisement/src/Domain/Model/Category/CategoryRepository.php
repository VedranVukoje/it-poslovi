<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Category;

use JobAd\Domain\Collection;
/**
 *
 * @author vedran
 */
interface CategoryRepository
{
    public function nextIdentity();
    public function ofId(Id $id): Category;
    public function add(Category $type_of_job);
    public function query(CategorySpecification $specification): Collection;
}
