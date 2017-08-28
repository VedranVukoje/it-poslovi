<?php

namespace JobAd\Application\Service\TypeOfJob;

use JobAd\Domain\Comand;
use JobAd\Application\Service\ApplicationService;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
use JobAd\Domain\Model\TypeOfJob\Specification\TypeOfJobIsUniqu;
use JobAd\Domain\Model\TypeOfJob\FactoryTypeOfJob;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobDTOAssembler;
use JobAd\Domain\Model\TypeOfJob\Name;
use JobAd\Domain\Model\TypeOfJob\Exception\TypeOfJobMustBeUniqueException;

/**
 * Description of NewTypeOfJob
 *
 * @author vedran
 */
class NewTypeOfJobService implements ApplicationService
{
    
    private $reposyitory;
    private $factory;
    private $dtoAssebler;
    
    /**
     * 
     * @param TypeOfJobRepository $repository
     * @param TypeOfJobSpecificationFactoryInterface $specificationFactory
     * @param TypeOfJobFactoryInterface $factory
     */
    public function __construct(
            TypeOfJobRepository $repository, 
            FactoryTypeOfJob $factory,
            TypeOfJobDTOAssembler $dtoAssebler
            )
    {
        $this->reposyitory = $repository;
        $this->factory = $factory;
        $this->dtoAssebler = $dtoAssebler;
    }
    
    /**
     * 
     * @param Comand $request
     * @return TypeOfJobDTOAssembler
     * @throws TypeOfJobMustBeUniqueException
     */
    public function execute($request = null)
    {
        if(!$request instanceof Comand){
            return;
        }
        
        $typeOfJob = $this->factory->writeNewTypeOfJob(new Name($request->name()));
        
        if(!$this->reposyitory->query(new TypeOfJobIsUniqu($typeOfJob))){
            throw new TypeOfJobMustBeUniqueException(sprintf('Tip posla "%s" vec postoji.', (string)$typeOfJob->name()));
        }
        
        $this->reposyitory->add($typeOfJob);
    
        return $this->dtoAssebler->assemble($typeOfJob);
    }
}
