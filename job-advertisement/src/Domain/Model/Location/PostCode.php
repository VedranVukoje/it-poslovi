<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Location;


use JobAd\Domain\ValueObjects\ValueObject;
/**
 * Description of PostCode
 *
 * @author vedran
 */
class PostCode implements ValueObject
{
    private $value;
    
    public function __construct(int $value)
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
    
    private function setValue(int $value)
    {
        $this->value =  (string) $value;
    }
}
