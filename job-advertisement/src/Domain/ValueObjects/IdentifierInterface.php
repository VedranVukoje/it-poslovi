<?php

namespace JobAd\Domain\ValueObjects;


/**
 *
 * @author vvukoje
 */
interface IdentifierInterface extends ValueObject
{
    public static function generate();
}
