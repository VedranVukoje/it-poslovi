<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement;


use JobAd\Domain\ValueObjects\ValueObject;

/**
 * Description of Name
 *
 * 
 * Ovo ide u User Domen..
 * 
 * @author vedran
 */
class CompanyName  implements ValueObject
{
    /**
     *
     * @var type string
     */
    protected $value;
    
    public function __construct( $value )
    {
        $this->setValue($value);
    }
    
    private function setValue($value)
    {
        // ovo ce ici u Symfony Validate .
        $this->assertNotEmpty($value);
        $this->value = $value;
    }
    
    public static function fromNative()
    {
        ;
    }
    
    public function equals(ValueObject $object)
    {
        ;
    }
    
    private function assertNotEmpty( $value )
    {
        if(empty($value)){
            throw  new \InvalidArgumentException(' Prazno Kara... ');
        }
        
        $this->value = $value;
    }
    
    public function toString()
    {
        return $this->value;
    }
    
    public function __toString()
    {
        return $this->value;
    }
    
    
}
