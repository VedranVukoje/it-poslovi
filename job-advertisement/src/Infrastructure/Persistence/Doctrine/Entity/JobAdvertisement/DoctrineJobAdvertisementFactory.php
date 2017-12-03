<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\JobAdvertisement;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementFactory;
/**
 * Description of DoctrineJobAdvertisementFactory
 *
 * @author vedran
 */
class DoctrineJobAdvertisementFactory implements JobAdvertisementFactory
{
    public static function draft(string $pozitonTitle, string $description, string $howToApplay)
    {
        return DoctreineJobAdvertisement::draft($pozitonTitle, $description, $howToApplay);
    }
}
