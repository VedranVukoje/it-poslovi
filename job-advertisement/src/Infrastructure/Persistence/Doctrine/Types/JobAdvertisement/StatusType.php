<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Types\JobAdvertisement;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\SmallIntType;

use JobAd\Domain\Model\JobAdvertisement\Status;

/**
 * Description of StatusType
 *
 * @author vedran
 */
class StatusType extends SmallIntType
{
    const NAME = 'job_add_poziton_title';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Status::fromNative($value);
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
