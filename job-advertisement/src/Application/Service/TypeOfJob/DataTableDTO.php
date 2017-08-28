<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\TypeOfJob;

use JobAd\Domain\Model\TypeOfJob\TypeOfJobDTOAssembler;
/**
 * Description of DataTableDTO
 *
 * @author vedran
 */
class DataTableDTO implements TypeOfJobDTOAssembler
{
    private $data;
    
    public function assemble($typeOfJobs)
    {
        
        $this->data['recordsFiltered'] = count($typeOfJobs);
        
        $row = [];
        foreach ($typeOfJobs as $typeOfJob){
            $row[] = ['id' => (string)$typeOfJob->id(), 'name' => (string)$typeOfJob->name(), 'status' => (string)$typeOfJob->status()];
        }
        $this->data['data'] = $row;
        
        $this->data['recordsTotal'] = count($row); 
        
        
        return $this;
    }
    
    public function data()
    {
        return $this->data;
    }
}
