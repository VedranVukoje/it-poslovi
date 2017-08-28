<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement\Events;

use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\JobAdvertisement\Id;
use DateTimeImmutable;

use JobAd\Domain\Model\TypeOfJob\TypeOfJob;

/**
 * Description of TypeOfJobWasAddToAdvertisement
 *
 * @author vedran
 */
class TypeOfJobWasAddedToJobAdvertisement implements DomainEvent
{

    private $id;
    private $typeOfJob;
    private $date;

    public function __construct(Id $id, TypeOfJob $typeOfJob)
    {
        $this->id = $id;
        $this->typeOfJob = $typeOfJob;
        $this->date = new DateTimeImmutable();
    }

    public function id()
    {
        return $this->id;
    }

    public function typeOfJob()
    {
        return $this->typeOfJob;
    }

    public function occurredOn()
    {
        return $this->date;
    }

}
