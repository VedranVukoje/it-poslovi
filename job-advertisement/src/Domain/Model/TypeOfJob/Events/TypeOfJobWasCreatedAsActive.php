<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Domain\Model\TypeOfJob\Events;

use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\TypeOfJob\Id;
use JobAd\Domain\Model\TypeOfJob\Name;
use DateTimeImmutable;
/**
 * Description of TypeOfJobWasCreatedAsActive
 * JobAd\Domain\Model\TypeOfJob\Events\TypeOfJobWasCreatedAsActive
 * @author vedran
 */
class TypeOfJobWasCreatedAsActive implements DomainEvent
{
    
    private $id;
    private $name;
    private $createdAt;
    private $updatedAt;
    private $occurredOn;

    public function __construct(Id $id, Name $name, DateTimeImmutable $createdAt, DateTimeImmutable $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->occurredOn = new DateTimeImmutable();
    }


    public function id()
    {
        return $this->id;
    }
    
    public function name()
    {
        return $this->name;
    }
    
    public function createdAt()
    {
        return $this->createdAt;
    }
    
    public function updatedAt()
    {
        return $this->updatedAt;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
