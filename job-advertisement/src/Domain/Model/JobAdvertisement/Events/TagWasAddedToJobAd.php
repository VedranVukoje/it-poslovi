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
//use JobAd\Domain\Model\Tag\Tag;

/**
 * Description of TagWasAddedToJobAd
 *
 * @author vedran
 */
class TagWasAddedToJobAd implements DomainEvent
{

    private $id;
    private $tagId;
    private $name;
    private $occurredOn;

    public function __construct(string $id, string $tagId, string $name)
    {
        $this->id = $id;
        $this->tagId = $tagId;
        $this->name = $name;
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

    public function name()
    {
        return $this->name;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
