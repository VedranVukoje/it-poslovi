<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Lib\Form\Type;

//use Symfony\Component\Form\FormInterface;
//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use JobAd\Domain\Model\Category\Category;

/**
 * Description of AdCategoryChoiceType
 *
 * @author vedran
 */
class CategoryChoiceType extends AbstractType
{

    public function getParent()
    {
        return EntityType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Category::class,
            'choice_label' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                                ->orderBy('t.name', 'ASC');
            }
        ]);
    }

}
