<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\TypeOfJob;

/**
 * Description of TypeOfJobHydrator
 *
 * @author vedran
 */
class TypeOfJobHydrator extends TypeOfJob implements TypeOfJobHydratorInterface
{
    public function extract(TypeOfJob $typeOfJob): array
    {
        return [
            'id' => (string) $typeOfJob->id,
            'name' => (string) $typeOfJob->name, 
            'status' => (string) $typeOfJob->status,
            'createdAt' => $typeOfJob->createdAt->format('d.m.Y H:i:s'),
            'updatedAt' => $typeOfJob->updatedAt->format('d.m.Y H:i:s')
        ];
    }
    
    public function hydrate(array $data, TypeOfJob $typeOfJob): TypeOfJob
    {
        
        $typeOfJob->name = new Name($data['name']);
        if(isset($data['status'])){
            $typeOfJob->status = Status::fromNative($data['status']);
        }
        if(isset($data['createdAt'])){
            $typeOfJob->createdAt = new \DateTimeImmutable($data['createdAt']);
        }
        if(isset($data['updatedAt'])){
            $typeOfJob->updatedAt = new \DateTimeImmutable($data['updatedAt']);
        }
        
        return $typeOfJob;
    }
    
    public function __construct()
    {
        
    }
}
