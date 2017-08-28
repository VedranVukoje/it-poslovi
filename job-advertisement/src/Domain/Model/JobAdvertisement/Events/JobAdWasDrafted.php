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
use JobAd\Domain\Model\JobAdvertisement\PozitonTitle;
use JobAd\Domain\Model\JobAdvertisement\Description;
use JobAd\Domain\Model\JobAdvertisement\HowToApplay;

/**
 * Description of DraftWasCreated
 *
 * @author vedran
 */
class JobAdWasDrafted implements DomainEvent
{
    
    private $id;
    private $date;
    private $pozitonTitle;
    private $description;
    private $howToApplay;
    
    public function __construct(Id $id, PozitonTitle $pozitonTitle, Description $description, HowToApplay $howToApplay)
    {
        $this->id = $id;
        $this->pozitonTitle = $pozitonTitle;
        $this->description = $description;
        $this->howToApplay = $howToApplay;
        $this->date = new DateTimeImmutable();
    }
    
    public function pozitonTitle()
    {
        return $this->pozitonTitle;
    }
    
    public function description()
    {
        return $this->description;
    }
    
    public function howToApplay()
    {
        return $this->howToApplay;
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
