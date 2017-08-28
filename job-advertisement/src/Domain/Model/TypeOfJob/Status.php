<?php

namespace JobAd\Domain\Model\TypeOfJob;

use JobAd\Domain\ValueObjects\ValueObject;

/**
 * Description of Status
 *
 * @author vedran
 */
class Status implements ValueObject
{

    const DELETE = '0';
    const BLOCK = '1';
    const ACTIVE = '2';

    private $value;

    public static function delete()
    {
        return new static(self::DELETE);
    }

    public static function active()
    {
        return new static(self::ACTIVE);
    }

    public static function block()
    {
        return new static(self::BLOCK);
    }

    public static function fromNative()
    {

        if (func_num_args()) {
            $arg = func_get_arg(0);

            // ne znam da li moze ????????
            if ($arg instanceof Status) {
                return new static((string) $arg);
            }

//        $valid = [0,1,2 ....];
            $valid = array_flip(StatusNames::datat());
            if (is_numeric($arg) && in_array($arg, $valid)) {
                return new static($arg);
            }
            
            throw new \InvalidArgumentException(sprintf('Instanca Status - a ili 0, 1, 2'));
        }
        throw new \InvalidArgumentException(sprintf('nemas argument u funkciji....'));
    }

    public function toInt()
    {
        return (int) $this->value;
    }

    public function toString()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function equals(ValueObject $object)
    {
        return $object == $this;
    }

    private function __construct($value)
    {
        $this->value = (string) $value;
    }

}
