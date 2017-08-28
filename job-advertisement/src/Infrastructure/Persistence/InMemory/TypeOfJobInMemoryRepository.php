<?php

namespace JobAd\Infrastructure\Persistence\InMemory;

use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\TypeOfJob\Id;
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobSpecification;



/**
 * Description of InMemoryPostRepository
 *
 * @author vedran
 */
class TypeOfJobInMemoryRepository implements TypeOfJobRepository
{
    
    /**
     *
     * @var TypeOfJob[] 
     */
    private $typeOfJob = [];
    
    
    public function __construct()
    {
        $this->typeOfJob = new TypeOfJobCollection();
    }
    
    public function nextIdentity()
    {
        return Id::generate();
    }

    public function add(TypeOfJob $type_of_job)
    {
        $this->typeOfJob->set((string)$type_of_job->id(),$type_of_job);
    }
    
    public function byIds(array $ids = [])
    {
        return $this->typeOfJob->filter(function(TypeOfJob $type_of_job) use ($ids){
            return in_array((string)$type_of_job->id(), $ids);
        });
    }
    
    public function byId(Id $id)
    {
        return $this->typeOfJob->get((string)$id);
    }
    
    
    
    /**
     * 
     * @param TypeOfJobSpecification $specification
     * @return type
     */
    public function query(TypeOfJobSpecification $specification)
    {
        return $this->typeOfJob->filter(function(TypeOfJob $type_of_job) use ($specification) {
            return $specification->specifies($type_of_job);
//            if($specification->specifies($type_of_job)){
//                return $type_of_job;
//            }
        });
    }
    

    public function all()
    {
        return $this->typeOfJob;
    }
}
