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
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;

/**
 * Description of JobAdTypeOfJobsWasManaged
 *
 * @author vedran
 */
class JobAdTypeOfJobsWasManaged implements DomainEvent
{

    private $id;
    private $fresh;
    private $add;
    private $remove;
    private $occurredOn;

    public function __construct(Id $id, TypeOfJobCollection $fresh, TypeOfJobCollection $add, TypeOfJobCollection $remove)
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

    public function add()
    {
        return $this->add;
    }

    public function remove()
    {
        return $this->remove;
    }
    
    public function fresh()
    {
        return $this->fresh;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
