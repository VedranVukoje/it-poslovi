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
 * Description of TagWasRemovedFromJobAd
 *
 * @author vedran
 */
class TagWasRemovedFromJobAd implements DomainEvent
{
    
    private $id;
    private $tagId;
    private $occurredOn;


    public function __construct(string $id, string $tagId)
    {
        $this->id = $id;
        $this->tagId = $tagId;
        $this->occurredOn = new DateTimeImmutable();
    }
    
    public function id()
    {
        return $this->id;
    }
    
    public function tagId()
    {
        return $this->tagId;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
