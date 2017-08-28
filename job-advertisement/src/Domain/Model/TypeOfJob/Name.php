<?php

namespace JobAd\Domain\Model\TypeOfJob;

use JobAd\Domain\ValueObjects\ValueObject;

/**
 * Description of Name
 *
 * @author vedran
 */
class Name implements ValueObject
{
    
    protected $value;
    
    public function __construct( $value )
    {
        $this->value = $value;
    }
    
    public function equals(ValueObject $object)
    {
        return $this == $object;
    }
    
    public static function fromNative()
    {
        $var = func_get_arg(0);
        if(is_string($var)){
            return new static($var);
        }
        
        throw new \InvalidArgumentException(sprintf('String i jos neke validacije koje nece biti ovde ...'));
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
