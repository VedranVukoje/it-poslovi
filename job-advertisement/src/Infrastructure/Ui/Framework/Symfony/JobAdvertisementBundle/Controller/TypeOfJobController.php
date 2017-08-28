<?php

/*
 *  ItPoslovi
 *  Vedran Vukoje Ja:
 *  vedran.vukoje@gmail.com
 */

namespace JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use JobAd\Application\Service\TypeOfJob\NewTypeOfJobComand;
//use JobAd\Application\Service\FormService;
//use JobAd\Infrastructure\Adapter\SymfonyFormFactory;
//use JobAd\Infrastructure\Ui\Lib\Form\FormFactory;
use JobAd\Infrastructure\Ui\Lib\Form\Type\TypeOfJobType;
//use JobAd\Application\Service\TypeOfJob\FormTypeOfJobService;
//use JobAd\Application\Service\TypeOfJob\ViewTypeOfJobService;

//use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormError;
//use JobAd\Application\Service\TypeOfJob\ManageTypeOfJobService;
use JobAd\Infrastructure\Persistence\Doctrine\TypeOfJobDoctrineRepository;
use JobAd\Application\Service\TypeOfJob\AjaxArchive;
use JobAd\Application\Service\TypeOfJob\DataTableDTO;

/**
 * Description of ItPosloviController
 *
 * @author vedran
 */
class TypeOfJobController extends Controller
{

    /**
     * @Route("/Tipovi_Poslova", name="archive_type_of_job")
     * @return type
     */
    public function archiveAction()
    {

        return $this->render('@it_poslovi/typeofjob.html.twig');
    }

    /**
     * @Route("/Ajax_Tipovi_Poslova", name="ajax_archive_type_of_job")
     * @return type
     */
    public function ajaxArchiveAction(Request $request)
    {

        // prebaciti u servis ..
        $service = new AjaxArchive(new TypeOfJobDoctrineRepository($this->get('doctrine.orm.default_entity_manager')), new DataTableDTO());

        $response = new JsonResponse();
        $response->setData($service->execute($request)->data());
        return $response;
    }

    /**
     * 
     * @Route("/tip_posla/{id}", name="manage_type_of_job")
     * @param Request $request
     * @return Response
     */
    public function manageTypeOfJobAction(Request $request, $id = null)
    {

        $logger = $this->get('logger');

        $form = $this->get('it_poslovi.symfony.form.factory')->create(new TypeOfJobType(), null, [
            'attr' => [
                'class' => 'form-horizontal',
                'role' => 'form'
            ]
        ]);

        try {

            if ($id) {
                // popunjavamo symfony formu sa typeofjob (DB...). i polja na formi ce se popuniti
                
                $form->setData($this->get('it_poslovi.typeofjob.view')->execute($id));
            }

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->get('it_poslovi.typeofjob.manage')->execute($form->getData());
            }
        } catch (\InvalidArgumentException $ex) {
            $log = $ex->getMessage();
            $form->addError(new FormError($log));
        } catch (\Exception $ex) {
            $log = $ex->getMessage();
            $form->addError(new FormError($log));
        } finally {
            if ($log ?? null) {
                $logger->info($log);
            }
        }

        return $this->render('@it_poslovi/TypeOfJob/form.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}
