<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Location;

use JobAd\Domain\ValueObjects\ValueObject;
/**
 * Description of SerbiaCites
 *
 * @author vedran
 */
class City implements ValueObject
{
    
    protected $name;
    protected $postCode;
    
    public function __construct(PostCode $postCode, string $name)
    {
        $this->name = $name;
        $this->postCode = $postCode;
    }
    
    public function postCode()
    {
        return $this->postCode;
    }


    public static function fromNative()
    {
        // Location.City.orm.xml
    }
    
    public function equals(ValueObject $object)
    {
        ;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
