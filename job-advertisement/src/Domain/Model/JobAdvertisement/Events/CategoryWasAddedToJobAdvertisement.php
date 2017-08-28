<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement\Events;

use DateTimeImmutable;
use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\Category\Category;

/**
 * Description of CategoryWasAddToAdvertisement
 *
 * @author vedran
 */
class CategoryWasAddedToJobAdvertisement implements DomainEvent
{

    private $id;
    private $category;
    private $date;

    public function __construct(Id $id, Category $cagegory)
    {
        $this->id = $id;
        $this->category = $cagegory;
        $this->date = new DateTimeImmutable();
    }
    
    public function category()
    {
        return $this->category;
    }

    public function occurredOn()
    {
        return $this->date;
    }

    /**
     * 
     * @return Id
     */
    public function id()
    {
        return $this->id;
    }

}
