<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement\Events;

use JobAd\Domain\EventStream;
use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
/**
 * Description of JobAdEventStream
 *
 * @author vedran
 */
class JobAdEventStream implements EventStream
{
    
    private $id;
    private $type;
    private $stream;
    private $occurredOn;
    
    public function __construct(Uuid $id, string $type, array $stram)
    {
        $this->id = $id;
        $this->type = $type;
        $this->stream = $stram;
        $this->occurredOn = new DateTimeImmutable;
    }


    public function id(): Uuid 
    {
        return $this->id;
    }
    
    public function type(): string
    {
        return $this->type;
    }
    
    public function stream(): array
    {
        return $this->stream;
    }
    
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
