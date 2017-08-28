<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Types\JobAdvertisement;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

use JobAd\Domain\Model\JobAdvertisement\Description;

/**
 * Description of DescriptionType
 *
 * @author vedran
 */
class DescriptionType extends TextType
{
    const NAME = 'job_add_description';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Description($value);
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
