<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Types\Tag;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use JobAd\Domain\Model\Tag\Name;
/**
 * Description of NameType
 * JobAd\Infrastructure\Persistence\Doctrine\Types\Tag\NameType
 * @author vedran
 */
class NameType extends StringType
{
    const NAME = 'tag_name';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Name($value);
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
