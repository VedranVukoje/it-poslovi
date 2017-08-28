<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Types\TypeOfJob;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

use JobAd\Domain\Model\TypeOfJob\Name;
/**
 * Description of JobOfTypeNameType
 *
 * @author vedran
 */
class JobOfTypeNameType extends StringType
{
    
    const NAME = 'joboftypename';
    
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Name($value);
    }
    
    public function getName()
    {
        return self::NAME;
    }
}
