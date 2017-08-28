<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Framework\Symfony\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JobAd\Domain\Model\Category\Category;
/**
 * Description of CategoryData
 *
 * @author vedran
 */
class CategoryData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $manager->persist(Category::fromName('Dizajn'));
        $manager->persist(Category::fromName('Programiranje'));
        $manager->persist(Category::fromName('Projek menadzment'));
        $manager->persist(Category::fromName('Database administrator'));
        $manager->persist(Category::fromName('Network administrator'));
        $manager->persist(Category::fromName('Linux administrator'));
        $manager->persist(Category::fromName('Windows administrator'));
        $manager->persist(Category::fromName('PC serviser'));
        $manager->persist(Category::fromName('Prodaja'));
        $manager->persist(Category::fromName('QA'));
        $manager->persist(Category::fromName('Ostalo'));
        $manager->flush();
    }

}
