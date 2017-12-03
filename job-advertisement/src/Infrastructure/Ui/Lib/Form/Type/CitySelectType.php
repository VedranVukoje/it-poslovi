<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Lib\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\Location\DoctrineCity;
//use JobAd\Domain\Model\Location\City;
use Doctrine\Common\Cache\ApcuCache;
/**
 * Description of CitySelectType
 *
 * @author vedran
 */
class CitySelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('city', EntityType::class, [
            'label' => false,
            'class' => DoctrineCity::class,
            'choice_label' => function ($city) {
                return (string) $city;
            },
            'query_builder' => function (EntityRepository $er) {
                $query = $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                
                
                return $query;
            }
        ]);
        
//        $builder->get('city')->addModelTransformer(new CallbackTransformer(function($city){
//            dump($city);
//            
//            return $city;
//        }, function($city){
//            return [(string) $city => (string) $city->postCode()];
//        }));
    }
}
