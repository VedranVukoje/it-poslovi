<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementHydrator;
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
    private $document = [
        'index' => 'it-poslovi',
        'type' => 'job-advertisement',
//        'version_type' => 'external'
    ];

    public function __construct(ElasticSearchClient $es)
    {
        $this->es = $es->build();
        $this->jobAdvertisment = new JobAdvertisementCollection();
    }

    public function nextIdentity()
    {
        return Id::generate();
    }

    public function ofId(Id $id): JobAdvertisement
    {
        /**
         * @todo NotFoundException.....
         */
        $es = $this->es->get(array_merge($this->document, ['id' => (string) $id]));

        return (new JobAdvertisementHydrator)
                        ->hydrate($es['_source'], new JobAdvertisement($id));
    }

    public function add(JobAdvertisement $jobAdvertisement)
    {
        $body = (new JobAdvertisementHydrator)->extract($jobAdvertisement);
        
        switch ($jobAdvertisement->isNew()) {
            case true:
                $document = array_merge($this->document, [
                    'body' => $body,
                    'id' => (string) $jobAdvertisement->id()
                ]);
                $this->es->index($document);
                break;
            case false:
                $document = array_merge($this->document, [
                    'body' => ['doc' => $body],
                    'id' => (string) $jobAdvertisement->id()
                ]);
                $this->es->update($document);
                break;
        }
    }

    public function query($specification)
    {
        
    }

}
