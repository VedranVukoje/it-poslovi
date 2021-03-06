<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Types\TypeOfJob;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\SmallIntType;

use JobAd\Domain\Model\TypeOfJob\Status;
/**
 * Description of JobOfTypeStatus
 *
 * @author vedran
 */
class JobOfTypeStatusType extends SmallIntType
{
    const STATUS = 'joboftypestatus';
    
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Status::fromNative($value);
    }
    
    public function getName()
    {
        return self::STATUS;
    }
}
