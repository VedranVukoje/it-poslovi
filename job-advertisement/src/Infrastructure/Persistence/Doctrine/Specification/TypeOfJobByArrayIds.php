<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\Doctrine\Specification;

use JobAd\Domain\Model\TypeOfJob\TypeOfJobSpecification;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
/**
 * Description of DoctrineTypeOfJobByArrayIds
 *
 * @author vedran
 */
class TypeOfJobByArrayIds implements TypeOfJobSpecification
{
    
    private $ids;
    
    public function __construct(array $ids = [])
    {
        $this->setIds($ids);
    }

    public function specifies(TypeOfJobRepository $repo)
    {
        $dql = "SELECT t FROM ".TypeOfJob::class." t WHERE t.id IN (".$this->ids.") ";
        
        return $repo->readDataByDQL($dql, []);
    }
    
    private function setIds(array $ids = [])
    {
        $this->ids = implode(',', array_map(function($id){
            return "'".$id."'";
        }, $ids));
    }
}
