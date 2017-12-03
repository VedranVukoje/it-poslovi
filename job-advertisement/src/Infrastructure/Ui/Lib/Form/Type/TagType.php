<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Lib\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\Tag\DoctrineTag;
/**
 * Description of TagType
 *
 * @author vedran
 */
class TagType extends AbstractType
{
    public function getParent()
    {
        return EntityType::class;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => DoctrineTag::class,
            'choice_label' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                                ->orderBy('t.name', 'ASC');
            }
        ]);

    }
}
