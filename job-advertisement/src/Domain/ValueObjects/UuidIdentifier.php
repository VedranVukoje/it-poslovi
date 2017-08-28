<?php

namespace JobAd\Domain\ValueObjects;

use JobAd\Domain\ValueObjects\ValueObject;
use Ramsey\Uuid\Uuid;


/**
 * Description of UuidIdentifier
 *
 * @author vvukoje
 */
abstract class UuidIdentifier implements IdentifierInterface
{

    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    public static function fromNative()
    {
        $string = func_get_arg(0);
        if(is_string($string)){
            return new static(Uuid::fromString($string));
        }
    }

    public function toString()
    {
        return $this->value->toString();
    }

    public function __toString()
    {
        return $this->value->toString();
    }
    
    public function equals(ValueObject $object)
    {
        return $this == $object;
    }
}
