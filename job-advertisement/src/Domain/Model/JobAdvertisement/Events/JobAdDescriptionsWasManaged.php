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
//use JobAd\Domain\Model\JobAdvertisement\PozitonTitle;
//use JobAd\Domain\Model\JobAdvertisement\Description;
//use JobAd\Domain\Model\JobAdvertisement\HowToApply;
/**
 * Description of JobAdDescriptionsWasManaged
 *
 * @author vedran
 */
class JobAdDescriptionsWasManaged implements DomainEvent
{
    private $id;
    private $occurredOn;
    private $pozitonTitle;
    private $description;
    private $howToApply;
    
    public function __construct(string $id, string $pozitonTitle, string $description, string $howToApply)
    {
        $this->id = $id;
        $this->pozitonTitle = $pozitonTitle;
        $this->description = $description;
        $this->howToApply = $howToApply;
        $this->occurredOn = new DateTimeImmutable();
    }
    
    public function pozitonTitle()
    {
        return $this->pozitonTitle;
    }
    
    public function description()
    {
        return $this->description;
    }
    
    public function howToApply()
    {
        return $this->howToApply;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }
    
    public function id()
    {
        return $this->id;
    }
}
