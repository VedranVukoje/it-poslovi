<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service;

/**
 * Description of Transaction
 * 
 * JobAd\Application\Service\Transaction
 * 
 * @author vedran
 */
class Transaction implements ApplicationService
{
    
    private $service;
    private $session;
    
    public function __construct(ApplicationService $service, TransactionalSession $session)
    {
        $this->service = $service;
        $this->session = $session;
    }
    
    public function execute($request = null)
    {
        if(empty($this->service)){
            throw new \Exception('Transakcija..........');
        }
        
        $operations = function() use ($request) {
            return $this->service->execute($request);
        };
        
        return $this->session->executeAtomically($operations);
    }
}
