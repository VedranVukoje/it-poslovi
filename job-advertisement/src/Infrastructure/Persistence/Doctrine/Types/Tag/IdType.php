<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Types\Tag;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use JobAd\Domain\Model\Tag\Id;
/**
 * Description of IdType
 * JobAd\Infrastructure\Persistence\Doctrine\Types\Tag\IdType
 * @author vedran
 */
class IdType extends GuidType
{
    const NAME = 'tag_id';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Id::fromNative($value);
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
