<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Tag;

use JobAd\Domain\ValueObjects\ValueObject;
/**
 * Description of Name
 *
 * @author vedran
 */
class Name implements ValueObject
{
    protected $value;
    
    public function __construct(string $value)
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
    
    public function __toString()
    {
        return $this->value;
    }
    
    private function setValue(string $value)
    {
        $this->value = $value;
    }
}
