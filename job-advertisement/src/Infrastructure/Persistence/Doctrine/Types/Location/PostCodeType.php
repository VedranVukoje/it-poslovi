<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Types\Location;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

use JobAd\Domain\Model\Location\PostCode;
/**
 * Description of PostCode
 *
 * @author vedran
 */
class PostCodeType extends IntegerType
{
    const NAME = 'postcode';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new PostCode($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
    
    public function getName()
    {
        return self::NAME;
    }
}
