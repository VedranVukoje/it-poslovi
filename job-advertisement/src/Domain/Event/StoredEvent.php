<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Event;

use DateTimeImmutable;

/**
 * Description of StoredEvent
 * 
 * @author vedran
 */
class StoredEvent
{

    /**
     * @var int
     */
    private $eventId;

    /**
     * @var string
     */
    private $typeName;

    /**
     * @var \DateTime
     */
    private $occurredOn;

    /**
     * @var string
     */
    private $eventBody;

    public function __construct(string $typeName, DateTimeImmutable $occurredOn, string $eventBody)
    {
        $this->typeName = $typeName;
        $this->occurredOn = $occurredOn;
        $this->eventBody = $eventBody;
    }

    public function eventId()
    {
        return $this->eventId;
    }

    public function occurredOn()
    {
        return $this->occurredOn();
    }
    
    public function eventBody()
    {
        return $this->eventBody;
    }

}
