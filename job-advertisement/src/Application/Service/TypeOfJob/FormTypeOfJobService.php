<?php

/*
 *  ItPoslovi
 *  Vedran Vukoje Ja:
 *  vedran.vukoje@gmail.com
 */

namespace JobAd\Application\Service\TypeOfJob;

use JobAd\Application\Service\ApplicationService;
use JobAd\Application\Contract\Form;
use JobAd\Application\Service\TypeOfJob\NewTypeOfJobComand;
/**
 * Description of FormTypeOfJobService
 *
 * @author vedran
 */
class FormTypeOfJobService implements ApplicationService
{
    
    private $form;
    private $service;
    
    public function __construct(ApplicationService $service, Form $form)
    {
        $this->form = $form;
        $this->service = $service;
    }




    public function execute($request = null)
    {
        ;
    }
}
