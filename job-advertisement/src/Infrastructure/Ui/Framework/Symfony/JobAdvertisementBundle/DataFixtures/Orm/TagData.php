<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Framework\Symfony\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JobAd\Domain\Model\Tag\Tag;

/**
 * Description of TagData
 *
 * @author vedran
 */
class TagData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        foreach ([
    'Poslovi', 'Posao', 'It', 'Beograd', 'Novi Sad',
    'Programiranje', 'Dizajn', 'Stalni', 'Honorarni/Freelance',
    'html5', 'css', 'JavaScript', 'Angular', 'Electorn', 'PHP',
    'c','c++','c\c++', 'Java', 'MySQL', 'Oracle', 'QA',
    'Linux', 'Windows'
        ] as $tag) {
            $manager->persist(Tag::fromName($tag));
        }
        
        $manager->flush();
    }

}
