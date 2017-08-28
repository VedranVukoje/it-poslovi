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
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;

/**
 * Description of JobAddCategoresWsaManaged
 *
 * @author vedran
 */
class JobAdCategoresWsaManaged implements DomainEvent
{

    private $id;
    private $occurredOn;
    private $fresh;
    private $add;
    private $remove;

    public function __construct(Id $id, CategoryCollection $fresh, CategoryCollection $add, CategoryCollection $remove)
    {
        $this->id = $id;
        $this->fresh = $fresh;
        $this->add = $add;
        $this->remove = $remove;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function id()
    {
        return $this->id;
    }

    public function fresh()
    {
        return $this->new;
    }
    
    public function add()
    {
        return $this->add;
    }
    
    public function remove()
    {
        return $this->remove;
    }
    
    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
