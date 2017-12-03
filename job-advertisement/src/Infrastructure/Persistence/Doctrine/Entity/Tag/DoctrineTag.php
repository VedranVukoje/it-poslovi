<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\Tag;

use JobAd\Domain\Model\Tag\Tag;
use JobAd\Domain\Model\Tag\Id;
use JobAd\Domain\Model\Tag\Name;
/**
 * Description of DoctrineTag
 * 
 * @author vedran
 */
class DoctrineTag extends Tag
{
    public function __construct(Id $id, Name $name)
    {
        parent::__construct($id, $name);
    }
}
