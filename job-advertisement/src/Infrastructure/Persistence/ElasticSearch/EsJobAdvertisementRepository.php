<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
//use JobAd\Domain\Model\JobAdvertisement\Status;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\JobAdvertisement\Adapter\JobAdvertisementCollection;
use JobAd\Infrastructure\Persistence\ElasticSearch\ElasticSearchClient;

/**
 * Description of ElasticSearchRepository
 *
 * @author vedran
 */
class EsJobAdvertisementRepository implements JobAdvertisementRepository
{
    
    /**
     *
     * @todo umesto ovoga koristi curl neki lib...
     * @var ElasticSearchClient 
     */
    private $es;
    private $jobAdvertisment;
    private $params = [];

    public function __construct(ElasticSearchClient $es)
    {
        $this->es = $es->build();
        $this->jobAdvertisment = new JobAdvertisementCollection();
        $this->params = ['index' => 'it-poslovi', 'type' => 'job-advertisement'];
    }

    public function nextIdentity()
    {
        return Id::generate();
    }
    
    public function ofId(Id $id): JobAdvertisement
    {
        ;
    }


    public function add(JobAdvertisement $jobAdvertisement)
    {
        $this->params['id'] = (string) $jobAdvertisement->id();
        $body = $jobAdvertisement->extract();
        $this->params['body'] = $body;
        
        $this->params['version'] = $jobAdvertisement->version();
        switch($jobAdvertisement->isFirstVersion()){
            case true:$this->es->index($this->params);break;
            case false:$this->es->update($this->params);break;
        }
    }

    public function query($specification)
    {
        
    }

    public function byId(Id $id)
    {
        return $this->jobAdvertisment[(string) $id] ?? false;
    }

}
