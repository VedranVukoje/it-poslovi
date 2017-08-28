<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement;

use JobAd\Domain\ValueObjects\ValueObject;

/**
 * Description of Description
 *
 * @author vedran
 */
class Description implements ValueObject
{
    
    protected $value;
    
    public function __construct($value)
    {
        $this->setValue($value);
    }
    
    public static function fromNative()
    {
        ;
    }
    
    public function equals(ValueObject $object)
    {
        ;
    }

    private function setValue($value)
    {
        $this->value = $value;
    }
    
    public function __toString()
    {
        return $this->value;
    }
}
