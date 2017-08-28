<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\DataTransformer\TypeOfJob;

use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
/**
 * Description of TypeOfJobResponse
 *
 * 
 * samo READ objekat ...
 * @author vedran
 */
class TypeOfJobTransformer implements Transformer
{
    private $id;
    private $name;
    private $status;
    private $typeOfJob;
    
    public function __construct(TypeOfJob $typeOfJob)
    {
        $this->id = $typeOfJob->id();
        $this->name = $typeOfJob->name();
        $this->status = $typeOfJob->status();
        $this->typeOfJob = $typeOfJob;
    }
    
    public function id()
    {
        return (string) $this->id;
    }
    
    public function name()
    {
        return (string) $this->name;
    }
    
    public function status()
    {
        return (string) $this->status;
    }
    
    
}