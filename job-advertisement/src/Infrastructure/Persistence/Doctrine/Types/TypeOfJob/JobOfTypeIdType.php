<?php

namespace JobAd\Infrastructure\Persistence\Doctrine\Types\TypeOfJob;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

use JobAd\Domain\Model\TypeOfJob\Id;

/**
 * Description of DoctrineUuidType
 *
 * @author vedran
 */
class JobOfTypeIdType extends GuidType
{

    const JOBOFTYPEID = 'joboftypeid';

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
        return self::JOBOFTYPEID;
    }

}
