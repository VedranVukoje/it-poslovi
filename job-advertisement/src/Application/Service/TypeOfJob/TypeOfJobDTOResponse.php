<?php

/*
 *  ItPoslovi
 *  Vedran Vukoje Ja:
 *  vedran.vukoje@gmail.com
 */

namespace JobAd\Application\Service\TypeOfJob;

use JobAd\Domain\Model\TypeOfJob\TypeOfJobDTOAssembler;

/**
 * Description of TypeOfJobResponse
 *
 * @author vedran
 */
class TypeOfJobDTOResponse implements TypeOfJobDTOAssembler
{
    public $id;
    public $name;
    public $status;
    
    public function assemble($typeOfJob)
    {
        $this->id = $typeOfJob->id();
        $this->name = $typeOfJob->name();
        $this->status = $typeOfJob->status();
        
        return $this;
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