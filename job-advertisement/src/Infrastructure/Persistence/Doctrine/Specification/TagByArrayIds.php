<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Specification;

use JobAd\Domain\Model\Tag\Tag;
use JobAd\Domain\Model\Tag\TagSpecification;
use JobAd\Domain\Model\Tag\TagRepository;
use JobAd\Infrastructure\Persistence\Doctrine\Entity\Tag\DoctrineTag;
/**
 * Description of TagByArrayIds
 *
 * @author vedran
 */
class TagByArrayIds implements TagSpecification
{
    
    private $ids;


    public function __construct(array $ids)
    {
        $this->setIds($ids);
    }

    public function specifies(TagRepository $repo)
    {
        
//        dump($this->ids);
        
        $dql = "SELECT t FROM ".DoctrineTag::class." t WHERE t.id IN (".$this->ids.") ";
        
        return $repo->readDataByDQL($dql, [
//            'ids' => $this->ids
        ]);
    }
    
    private function setIds(array $ids = [])
    {
//        dump($ids);
        $this->ids = implode(',',array_map(function($tag){
            return "'".$tag['id']."'";
        }, $ids));
        
    }
}
