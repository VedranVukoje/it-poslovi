<?php

namespace JobAd\Domain;

/**
 *
 * @author vedran
 */
interface DomainEvent
{
    
    /**
     * @return ValueObject
     */
    public function id();
    
    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn();
    
}
