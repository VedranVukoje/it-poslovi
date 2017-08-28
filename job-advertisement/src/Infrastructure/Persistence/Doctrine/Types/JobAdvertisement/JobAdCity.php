<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Types\JobAdvertisement;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

use JobAd\Domain\Model\Location\City;
use JobAd\Domain\Model\Location\PostCode;
/**
 * Description of JobAdCity
 *
 * @author vedran
 */
class JobAdCity extends StringType
{
    const NAME = 'job_add_city';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $data = explode("|", $value);
        
        return new City(new PostCode((int) $data[0]), $data[1]);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string)$value->postCode()."|".(string) $value;
    }
    
    public function getName()
    {
        return self::NAME;
    }
}
