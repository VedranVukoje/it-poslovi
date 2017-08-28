<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Ui\Framework\Symfony\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JobAd\Domain\Model\TypeOfJob\Name;
use JobAd\Domain\Model\TypeOfJob\FactoryTypeOfJob;
/**
 * Description of TypeOfJobData
 *
 * @author vedran
 */
class TypeOfJobData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $manager->persist(FactoryTypeOfJob::writeNewTypeOfJob(new Name('Stalni')));
        $manager->persist(FactoryTypeOfJob::writeNewTypeOfJob(new Name('Honorarni')));
        $manager->persist(FactoryTypeOfJob::writeNewTypeOfJob(new Name('Freelance')));
        $manager->flush();
    }
}
