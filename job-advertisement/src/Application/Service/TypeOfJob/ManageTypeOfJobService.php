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
use JobAd\Domain\Model\TypeOfJob\Id;
use JobAd\Domain\Model\TypeOfJob\Name;
use JobAd\Domain\Model\TypeOfJob\Status;
/**
 * Description of ManageTypeOfJobService
 *
 * @author vedran
 */
class ManageTypeOfJobService implements ApplicationService {
    
    private $service;
    private $repository;
    private $assembler;
    
    public function __construct(ApplicationService $service, 
            TypeOfJobRepository $repository, 
            TypeOfJobDTOAssembler $assembler) {
        $this->service = $service;
        $this->repository = $repository;
        $this->assembler = $assembler;
    }
    
    public function execute($request = null) {
        
//        dump($request->status());
        
        if($request->id()){
            $typsofJob = $this->repository->byId(Id::fromNative($request->id()));
            $typsofJob->manage(new Name($request->name()), Status::fromNative($request->status));
            $this->repository->add($typsofJob);
        }else{
           $this->service->execute(new NewTypeOfJobComand($request->name())); 
        }
    }
    
}
