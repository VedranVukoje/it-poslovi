<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch;

use Psr\Log\LoggerInterface;
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
    private $log;
    private $hydrator;

    public function __construct(ElasticSearchClient $es, LoggerInterface $log)
    {
        $this->es = $es->build();
        $this->log = $log;
        $this->jobAdvertisment = new JobAdvertisementCollection();
        $this->hydrator = new JobAdvertisementHydrator($log);
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
        
        return $this->hydrate($id, $es['_source']);
    }

    public function add(JobAdvertisement $jobAdvertisement)
    {
        $body = $this->hydrator->extract($jobAdvertisement);

        $this->log->debug('EsJobAdvertisementRepository::add pre', [
            'jobAd' => $body
        ]);

        switch ($jobAdvertisement->isNew()) {
            case true:
                $document = array_merge($this->document, [
                    'body' => $body,
                    'id' => (string) $jobAdvertisement->id()
                ]);

                $this->log->debug('EsJobAdvertisementRepository::add insert', [
                    'document' => $document
                ]);

                $this->es->index($document);
                break;
            case false:
                $document = array_merge($this->document, [
                    'body' => ['doc' => $body],
                    'id' => (string) $jobAdvertisement->id()
                ]);
                
                $this->log->debug('EsJobAdvertisementRepository::add update', [
                    'document' => $document
                ]);
                
                $this->es->update($document);
                break;
        }
    }

    public function query($specification)
    {
        
    }
    
    private function hydrate(Id $id, array $_source): JobAdvertisement
    {
        return $this->hydrator->hydrate($_source, new JobAdvertisement($id));
    }

}
