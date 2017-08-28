<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\Category;

use JobAd\Domain\Model\Category\Category as Domain;

/**
 * Description of Category
 *
 * @author vedran
 */
class Category extends Domain
{
    public function __construct($id)
    {
        parent::__construct($id);
    }
}
