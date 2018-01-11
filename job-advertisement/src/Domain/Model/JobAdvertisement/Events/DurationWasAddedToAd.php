<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement\Events;

use DateTimeImmutable;
use JobAd\Domain\DomainEvent;
//use JobAd\Domain\Model\JobAdvertisement\Id;

/**
 * Description of DurationWasAddedToAd
 * 
 * @author vedran
 */
class DurationWasAddedToAd implements DomainEvent
{

    private $id;
    private $duration;
    private $occurredOn;

    public function __construct(string $id, string $duration)
    {
        $this->id = $id;
        $this->duration = $duration;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function id()
    {
        return $this->id;
    }
    
    public function duration()
    {
        return $this->duration;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
