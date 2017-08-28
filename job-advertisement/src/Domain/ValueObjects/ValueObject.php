<?php

namespace JobAd\Domain\ValueObjects;

/**
 *
 * @author vedran
 */
interface ValueObject
{
    public function equals(ValueObject $object);
    public function __toString();
    public static function fromNative();
}
