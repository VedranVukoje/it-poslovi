<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement;

use JobAd\Domain\ValueObjects\ValueObject;
/**
 * Description of Status
 *
 * @author vedran
 */
class Status implements ValueObject
{
    
    const DELET = '0';
    const DRAFT = '1';
    
    private $value;
    
    public static function draft()
    {
        return new static(self::DRAFT);
    }
    
    public static function fromNative()
    {
        if (func_num_args()) {
            $arg = func_get_arg(0);

            // ne znam da li moze ????????
            if ($arg instanceof Status) {
                return new static((string) $arg);
            }
            $valid = array_flip(StatusNames::datat());
            //        $valid = [0,1,2 ....];
            if (is_numeric($arg) && in_array($arg, $valid)) {
                return new static($arg);
            }
            
            throw new \InvalidArgumentException(sprintf('Status oglasa za posao.'));
        }
        throw new \InvalidArgumentException(sprintf('Status oglasa za posao nije prosledjen.'));
    }
    
    public function equals(ValueObject $object)
    {
        return $this == $object;
    }
    
    public function __toString()
    {
        return $this->value;
    }
    
    private function __construct($value)
    {
        $this->value = $value;
    }
}
