<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\ValueObjects;

use DateTimeImmutable;
use DateTime;
/**
 * Description of ItPosloviDateTime
 *
 * @author vedran
 * 
 * Vedran 04 veljace 2017
 * ItPosloviDateTime je najjadnija i najlosija implementacija value objekata .
 * Jednog dana prezidati voditi se ovim :
 * http://nicolopignatelli.github.io/valueobjects/api/2.x/namespace-ValueObjects.DateTime.html
 * 
 * 
 */
class ItPosloviDateTime extends DateTimeImmutable implements ValueObject
{

    /**
     *
     * @var DateTimeImmutable
     */
    private $value;
    
    private $format = 'd.m.Y H:i:s';
    
    public function __construct($value)
    {
        $this->value = $value;
    }
    
    /**
     * 
     * @param type string||DateTimeImmutable
     * @return ItPosloviDateTime
     * 
     * @throws InvalidArgumentException
     */
    public static function fromNative()
    {
        if (1 == func_num_args()) {
            $arg = func_get_arg(0);

            // ne znam da li moze ????????
            if ($arg instanceof DateTimeImmutable) {
                return new static($arg);
            }
            
            /**
             * @todo Ovo bas i ne znam !!! 
             */
            if(is_string($arg)){
                return new static(new DateTimeImmutable($arg));
            }
            
            throw new \InvalidArgumentException(sprintf('Ne ispravan argument string||DateTimeImmutable ItPosloviDateTimeImmutable:frimNative(%s)', $arg));
        }
        throw new \InvalidArgumentException(sprintf('nije prosledjen argument u fn - ju ItPosloviDateTimeImmutable:frimNative(NULL)'));
    }

    public static function now()
    {
        return new static(DateTimeImmutable::createFromMutable(new DateTime()));
    }
    
    public function format($format)
    {
        return $this->value->format($format);
    }
    
    /**
     * 
     * @param \JobAd\Domain\ValueObjects\ValueObject $object
     * @return bool
     */
    public function equals(ValueObject $object)
    {
        return $this == $object;
    }

    public function __toString()
    {
        return $this->value->format($this->format);
    }
    
    
    

}
