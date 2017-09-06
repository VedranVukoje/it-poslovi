<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JobAd\Domain\JobAdvertisementException;
//use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\Form\FormError;
use JobAd\Application\Service\JobAdvertisement\DraftAdvertisementService;
use JobAd\Application\Service\JobAdvertisement\AddCityToJobAd;
//use JobAd\Application\Service\JobAdvertisement\AddCategoryToJobAd;
//use JobAd\Application\Service\JobAdvertisement\AddTypeOfJobToJobAd;
use JobAd\Application\Service\JobAdvertisement\JobAdManageTypeOfJobs;
use JobAd\Application\Service\JobAdvertisement\JobAdManageCategores;
use JobAd\Application\Service\JobAdvertisement\JobAdvertisementFormResponse;
//use JobAd\Infrastructure\Persistence\InMemory\InMemoryJobAdvertisementRepo;
use JobAd\Infrastructure\Persistence\Doctrine\TypeOfJobDoctrineRepository;
//use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
//use JobAd\Domain\Model\JobAdvertisement\Name;
//use JobAd\Domain\Model\JobAdvertisement\Description;
//use JobAd\Domain\Model\JobAdvertisement\HowToApplay;
use JobAd\Infrastructure\Ui\Lib\Form\Type\JobAdvertisementType;
//use JobAd\Infrastructure\Persistence\Doctrine\CityDoctrineRepository;
//use JobAd\Infrastructure\Persistence\Doctrine\CategoryDoectrineRepository;
//use Elasticsearch\ClientBuilder;
//use JobAd\Domain\Model\TypeOfJob\Id;
use JobAd\Application\Service\Transaction;
use JobAd\Infrastructure\Application\Service\DoctrineSession;
//use JobAd\Application\Service\TypeOfJob\ViewTypeOfJobService;
//use JobAd\Application\Service\TypeOfJob\ViewTypeOfJobArrayCollectionResponse;
//use JobAd\Infrastructure\Persistence\Doctrine\Specification\TypeOfJobSepcificationFactory;
//use JobAd\Application\Service\Location\ViewCitiesService;
use JobAd\Infrastructure\Persistence\Doctrine\CityDoctrineRepository;
//use JobAd\Infrastructure\Persistence\Doctrine\Specification\CitySpecificationFactory;
//use JobAd\Application\Service\Category\ViewCategoryService;
use JobAd\Infrastructure\Persistence\Doctrine\CategoryDoectrineRepository;
//use JobAd\Infrastructure\Persistence\Doctrine\Specification\CategorySepecificationFactory;
use JobAd\Application\Service\BaseResponse;
use JobAd\Domain\DomainEventPublisher;
//use JobAd\Infrastructure\Application\Serialization\JMS\JMSFactory;
//use JobAd\Infrastructure\Application\Serialization\JMS\JMSSerializer;
//use JobAd\Application\Service\JobAdvertisement\AddTagToJobAd;
use JobAd\Application\Service\JobAdvertisement\JobAdManageTags;
use JobAd\Infrastructure\Persistence\Doctrine\TagDoctrineRepository;

/**
 * Description of JobAdvertismentController
 *
 * @author vedran
 */
class JobAdvertismentController extends Controller
{

    /**
     * 
     * @Route("/Postavi-Oglas/{id}/{version}", name="draft_job_ad")
     * 
     * @param Request $request
     * @return type
     */
    public function draftJobAddAction(Request $request, $id = null, int $version = 0)
    {

//        dump($id);

        $em = $this->get('doctrine.orm.default_entity_manager');

        $jobAdRepo = $this->get('it_poslovi.doctrine.job_advertisement_repo');
        $cityRepo = new CityDoctrineRepository($em);
        $tagRepo = new TagDoctrineRepository($em);

        if ($id) {
            /**
             * @todo prebaic u poseban Appliation \ Service \ Requst...
             */
            $jobByIdRequest = new \stdClass;
            $jobByIdRequest->id = $id;
            $jobByIdRequest->version = $version;
            $jobAd = $this->get('it_poslovi.view_job_advertisement')->execute($jobByIdRequest);
//            dump($jobAd);
        }


        $form = $this->get('it_poslovi.symfony.form.factory')->create(JobAdvertisementType::class, $jobAd ?? null, [
            'attr' => [
                'class' => 'form-horizontal',
                'role' => 'form'
            ],
            'em' => $em
        ]);
        try {


//            dump($form->getData());

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                /**
                 * @important @todo 
                 * ovo ovde namesti da bude u Kernel::request...
                 * 02 rujan 2017
                 * Ovo cu izbaciti iz servica i samog framework - a i ubaciti
                 * u neki AMQ . Sada samo pravim sinhrono.
                 */
                $this->get(DomainEventPublisher::class);

                $baseResponse = new BaseResponse();
                $baseResponse = new DraftAdvertisementService($baseResponse, $jobAdRepo, new JobAdvertisementFormResponse);
//                $baseResponse = new AddCategoryToJobAd($baseResponse, $jobAdRepo, new CategoryDoectrineRepository($em));
                $baseResponse = new JobAdManageCategores($baseResponse, $jobAdRepo, new CategoryDoectrineRepository($em));
//                $baseResponse = new AddTypeOfJobToJobAd($baseResponse, $jobAdRepo, new TypeOfJobDoctrineRepository($em));
                $baseResponse = new JobAdManageTypeOfJobs($baseResponse, $jobAdRepo, new TypeOfJobDoctrineRepository($em));
//                $baseResponse = new AddTagToJobAd($baseResponse, $jobAdRepo, $tagRepo);
                $baseResponse = new JobAdManageTags($baseResponse, $jobAdRepo, $tagRepo);
                $baseResponse = new AddCityToJobAd($baseResponse, $jobAdRepo, $cityRepo);

                $baseResponse = new Transaction($baseResponse, new DoctrineSession($this->get('doctrine.orm.default_entity_manager')));
                $response = $baseResponse->execute($form->getData());

//                dump($form->getData());

                return $this->redirectToRoute('draft_job_ad', [
                            'id' => $form->getData()->id,
                            'version' => $form->getData()->version
                ]);
            }
        } catch (JobAdvertisementException $ex) {
            dump($ex);
        } catch (Exception $ex) {
            dump($ex);
        }

        return $this->render('@it_poslovi/jobadvertisment.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}

//        $client = \Elasticsearch\ClientBuilder::create()->build();

//        $esData = [
//            'index' => 'itposlovi',
////            'type' => 'jobadvertisment',
////            'id' => $draftResponse->id,
//            'body' => [
//                'mappings' => [
//                    'jobadvertisment' => [
//                        '_all' => ["enabled" => false],
//                        'properties' => [
//                            'id' => ['type' => 'string'],
//                            'pozitonTitle' => ['type' => 'string'],
//                            'description' => ['type' => 'text'],
//                            'howtoapplay' => ['type' => 'text'],
//                            'typeofjobs' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'categoryes' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'city' => ['properties' => ['postcode' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'status' => ['type' => 'text']
//                        ]
//                    ]
//                ]
//            ]
//        ];

//        $esData = [
//            'index' => 'itposlovi',
//            'type' => 'jobadvertisment',
//            'body' => [
//                'jobadvertisment' => [
////                        '_all' => ["enabled" => false],
//                    'properties' => [
////                            'id' => ['type' => 'string'],
////                            'pozitonTitle' => ['type' => 'string'],
////                            'description' => ['type' => 'text'],
////                            'howtoapplay' => ['type' => 'text'],
////                            'typeofjobs' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
////                            'categoryes' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
////                            'city' => ['properties' => ['postcode' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                        'status' => ['type' => 'text']
//                    ]
//                ]
//            ]
//        ];
//        $client->indices()->putMapping($esData);
//        $client->indices()->putSettings($esData);
//        $client->indices()->create($esData);
//        $client->index($esData);
//        $client->create($esData);
//        $client;
//        dump($esData);
