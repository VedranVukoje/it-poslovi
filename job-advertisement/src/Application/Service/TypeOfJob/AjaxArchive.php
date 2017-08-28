<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\TypeOfJob;

use JobAd\Application\Service\ApplicationService;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobDTOAssembler;
/**
 * Description of AjaxArchive
 *
 * @author vedran
 */
class AjaxArchive implements ApplicationService
{
    
    private $repo;
    private $assebler;
    
    public function __construct(TypeOfJobRepository $repo, TypeOfJobDTOAssembler $assebler)
    {
        $this->repo = $repo;
        $this->assebler = $assebler;
    }


    public function execute($request = null)
    {
        $typeOfJobs = $this->repo->dataTable([
            'start' => $request->get('start'),
            'length' => $request->get('length')
        ]);
        
        return $this->assebler->assemble($typeOfJobs);
    }
}
