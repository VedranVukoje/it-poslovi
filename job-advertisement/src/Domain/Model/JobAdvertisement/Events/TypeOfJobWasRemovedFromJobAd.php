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
 * Description of TypeOfJobWasRemoveedToJobAd
 *
 * @author vedran
 */
class TypeOfJobWasRemovedFromJobAd implements DomainEvent
{
    
    private $id;
    private $typeOfJobId;
    
    public function __construct(string $id,  string $typeOfJobId)
    {
        $this->id = $id;
        $this->typeOfJobId = $typeOfJobId;
    }
    
    public function id()
    {
        return $this->id;
    }
    
    public function typeOfJobId()
    {
        return $this->typeOfJobId;
    }
    
    public function occurredOn()
    {
        return $this->occurredOn();
    }
}
