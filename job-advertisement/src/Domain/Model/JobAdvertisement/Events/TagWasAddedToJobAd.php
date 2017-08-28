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
use JobAd\Domain\Model\Tag\Tag;
/**
 * Description of TagWasAddedToJobAd
 *
 * @author vedran
 */
class TagWasAddedToJobAd implements DomainEvent
{

    private $id;
    private $tag;
    private $occurredOn;

    public function __construct(Id $id, Tag $tag)
    {
        $this->id = $id;
        $this->tag = $tag;
        $this->occurredOn = new DateTimeImmutable();
    }
    
    
    public function id()
    {
        return  $this->id;
    }
    
    public function tag()
    {
        return $this->tag;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
