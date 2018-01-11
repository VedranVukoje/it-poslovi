<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement\Events;

use JobAd\Domain\DomainEvent;
use DateTimeImmutable;

/**
 * Description of TypeOfJobWasAddToAdvertisement
 *
 * @author vedran
 */
class TypeOfJobWasAddedToJobAd implements DomainEvent
{

    private $id;
    private $typeOfJobId;
    private $typeOfJobName;
    private $occurredOn;


    public function __construct(string $id,  string $typeOfJobId ,string $typeOfJobName)
    {
        $this->id = $id;
        $this->typeOfJobId = $typeOfJobId;
        $this->typeOfJobName = $typeOfJobName;
        $this->occurredOn = new DateTimeImmutable();
    }
    
    public function id()
    {
        return $this->id;
    }
    
    public function typeOfJobId()
    {
        return $this->typeOfJobId;
    }
    
    public function typeOfJobName()
    {
        return $this->typeOfJobName;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
