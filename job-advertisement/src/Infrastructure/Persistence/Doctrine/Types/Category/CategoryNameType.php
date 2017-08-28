<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Types\Category;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use JobAd\Domain\Model\Category\Name;
/**
 * Description of CategoryNameType
 * JobAd\Infrastructure\Persistence\Doctrine\Types\Category\CategoryNameType
 * @author vedran
 */
class CategoryNameType extends StringType
{
    const NAME = 'category_name';
    
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
