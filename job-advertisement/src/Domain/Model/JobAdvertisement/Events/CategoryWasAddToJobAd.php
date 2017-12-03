<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement\Events;

use DateTimeImmutable;
use JobAd\Domain\DomainEvent;

/**
 * Description of CategoryWasAddToJobAd
 *
 * JobAd\Domain\Model\JobAdvertisement\Events\CategoryWasAddToJobAd
 * JobAd.Domain.Model.JobAdvertisement.Events.CategoryWasAddToJobAd
 * @author vedran
 */
class CategoryWasAddToJobAd implements DomainEvent
{
    
    private $id;
    private $categoryId;
    private $name;
    private $occurredOn;


    public function __construct(string $id, string $categoryId, string $name)
    {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function id()
    {
        return $this->id;
    }
    
    public function categoryId()
    {
        return $this->categoryId;
    }
    
    public function name()
    {
        return $this->name;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
