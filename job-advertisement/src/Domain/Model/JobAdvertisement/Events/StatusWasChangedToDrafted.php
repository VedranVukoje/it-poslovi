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
 * Description of StatusWasChangedToDraft
 *
 * @author vedran
 */
class StatusWasChangedToDrafted implements DomainEvent
{
    private $id;
    private $status;
    private $occurredOn;
    
    public function __construct(string $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
        $this->occurredOn = new DateTimeImmutable();
    }
    
    public function id()
    {
        return $this->id;
    }
    
    public function status()
    {
        return $this->status;
    }
    
    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
