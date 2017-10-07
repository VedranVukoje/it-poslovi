<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Lib\Form\Type;

use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\CallbackTransformer;
//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;
//use Doctrine\ORM\EntityRepository;
//use Doctrine\ORM\EntityManager;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
//use Doctrine\Common\Collections\ArrayCollection;
use JobAd\Application\Service\JobAdvertisement\JobAdvertisementFormResponse;
use JobAd\Domain\Model\Tag\Tag;
use JobAd\Domain\Model\Category\Category;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\Location\City;
use Doctrine\Common\Collections\ArrayCollection;
//use JobAd\Domain\Model\Category\Category;

/**
 * Description of JobAdvertisementType
 *
 * @author vedran
 */
class JobAdvertisementType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', HiddenType::class)
                ->add('version', HiddenType::class)
                ->add('pozitonTitle', TextType::class, [
                    'label' => 'Naziv radnog mesta:',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label no-padding-right'
                    ]
                ])
                ->add('typeOfJobs', AdTypeOfJobSelectType::class, [
                    'label' => 'Tip posla:',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label no-padding-right'
                    ],
                    'multiple' => true,
                    'expanded' => true
                ])
                ->add('categoryes', CategoryChoiceType::class, [
                    'label' => 'Kategorija:',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label no-padding-right'
                    ],
                    'multiple' => true,
                    'expanded' => true
                ])
                ->add('city', CitySelectType::class, [
                    'label' => 'Lokacija:',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label no-padding-right'
                    ]
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Opis:',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label no-padding-right'
                    ]
                ])
                ->add('howToApllay', TextareaType::class, [
                    'label' => 'Kako aplicirati :',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label no-padding-right'
                    ]
                ])
                ->add('tags', TagType::class, [
                    'label' => 'Tagovi:',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label no-padding-right'
                    ],
                    'multiple' => true,
                    'expanded' => false
                ])
                ->add('end', DateType::class, [
                    'label' => 'Trajanje:',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label no-padding-right'
                    ],
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => ['class' => 'duration'],
                    'format' => 'dd.MM.yyyy'
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Snimi',
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ]
        ]);
        
        
        /**
         * @todo
         * Rascesljaj u privatne metode...
         */
        
        $em = $options['em'];

        $dateCallbackTransformer = new CallbackTransformer(function($date) {
            return new \DateTimeImmutable($date);
        }, function($date) {
            return $date->format('d.m.Y');
        });

        $builder->get('end')->addModelTransformer($dateCallbackTransformer);

        $tags = $builder->get('tags');
        $tags->addModelTransformer(new CallbackTransformer(function($tagsArray) use ($em) {
            
            if(empty($tagsArray)){
                return new ArrayCollection();
            }
            
            return new ArrayCollection($em->createQueryBuilder('t')
                            ->select('t')
                            ->from(Tag::class, 't')
                            ->where('t.id IN (:tags)')
                            ->setParameter('tags', array_values($tagsArray))
                            ->getQuery()
                            ->getResult());
        }, function($tags) {
            
//            if(empty($tags)){
//                return;
//            }
            
            return iterator_to_array($tags->map(function($tag){
                return ['id' => (string) $tag->id(), 'name' => (string) $tag->name(), 'slug' => $tag->slug()];
            }));
            
//            return array_map(function($tag) {
//                return ['id' => (string) $tag->id(), 'name' => (string) $tag->name(), 'slug' => $tag->slug()];
//            }, $tags);
        }));

        $categoryes = $builder->get('categoryes');
        $categoryes->addModelTransformer(new CallbackTransformer(function($categoryArray) use ($em) {
            
            if(empty($categoryArray)){
                return new ArrayCollection();
            }
            
            
            return new ArrayCollection($em->createQueryBuilder('c')
                            ->select('c')
                            ->from(Category::class, 'c')
                            ->where('c.id IN (:categores)')
                            ->setParameter('categores', array_values($categoryArray))
                            ->getQuery()
                            ->getResult());
        }, function($categores) {
            
//            if(empty($categores)){
//                return;
//            }
            
            return iterator_to_array($categores->map(function($category){
                return ['id' => (string) $category->id(), 'name' => (string) $category->name()];
            }));
            
//            return array_map(function($category) {
//                return ['id' => (string) $category->id(), 'name' => (string) $category->name()];
//            }, $categores);
        }));

        $builder->get('city')->addModelTransformer(new CallbackTransformer(function($cityArray) use ($em) {
            return $em->createQueryBuilder('c')
                            ->select('c')
                            ->from(City::class, 'c')
                            ->where('c.postCode = :postCode')
                            ->setParameter('postCode', $cityArray['postCode'])
                            ->getQuery()
                            ->getResult();
            
        }, function($city) {
            return [
                'name' => (string) $city['city'],
                'postCode' => (string) $city['city']->postCode()
            ];
        }));

        $typeOfJobs = $builder->get('typeOfJobs');
        $typeOfJobs->addModelTransformer(new CallbackTransformer(function($typeOfJobsArray) use ($em) {
            
//            dump($typeOfJobsArray);
//            
            if(empty($typeOfJobsArray)){
                return new ArrayCollection();
            }
            
            return new ArrayCollection($em->createQueryBuilder('t')
                            ->select('t')
                            ->from(TypeOfJob::class, 't')
                            ->where('t.id IN (:typeOfJobs)')
                            ->setParameter('typeOfJobs', array_values($typeOfJobsArray))
                            ->getQuery()
                            ->getResult());
        }, function($typeOfJobs) {
            
//            dump($typeOfJobs);
            
            return iterator_to_array($typeOfJobs->map(function($typeOfJob){
                return ['id' => (string) $typeOfJob->id(), 'name' => (string) $typeOfJob->name()];
            }));
            
//            return array_map(function($typeOfJob) {
//                return ['id' => (string) $typeOfJob->id(), 'name' => (string) $typeOfJob->name()];
//            }, $typeOfJobs);
        }));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('em');
        $resolver->setDefaults([
            'data_class' => JobAdvertisementFormResponse::class
        ]);
    }

}
