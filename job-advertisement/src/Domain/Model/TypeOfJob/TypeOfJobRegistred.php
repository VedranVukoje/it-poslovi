<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\TypeOfJob;

use JobAd\Domain\DomainEvent;
/**
 * Description of TypeOfJobRegistred
 *
 * @author vedran
 */
class TypeOfJobRegistred implements DomainEvent
{
    
    private $id;
    private $occurr;
    
    public function __construct(Id $id)
    {
        $this->id = $id;
        $this->occurr = new \DateTimeImmutable();
    }
    
    public function occurredOn()
    {
        return $this->occurr;
    }
    
    public function id()
    {
        return $this->id;
    }
}
