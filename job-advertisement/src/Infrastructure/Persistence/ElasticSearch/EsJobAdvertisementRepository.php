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


        switch ($jobAdvertisement->isNew()) {
            case true:
                $document = array_merge($this->document, [
                    'body' => $body,
                    'id' => (string) $jobAdvertisement->id()
                ]);
                
                $this->es->index($document);
                
                $this->log->debug('EsJobAdvertisementRepository::add insert', [
                    'id' => $body['id'],
                    'body' => $body
                ]);
                break;
            case false:
                
//                $debug = sprintf('categoryes: %s, typeofjobs: %s, tags: %s', count($body['categoryes']), count($body['typeofjobs']), count($body['tags']));
//                $this->log->debug($debug, []);
                
                $this->log->debug('tipovi posla count '. var_export($body['typeOfJobs'], true));
                
                $this->reSetKeys($body['categoryes']);
                $this->reSetKeys($body['typeOfJobs']);
                $this->reSetKeys($body['tags']);
                
                
                
                
                $document = array_merge($this->document, [
                    'body' => ['doc' => $body],
                    'id' => (string) $jobAdvertisement->id()
                ]);
                
                $this->es->update($document);
                
                $this->log->debug('EsJobAdvertisementRepository::add update', [
                    'id' => $body['id'],
                    'body' => $body
                ]);
                
                
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
    
    private function reSetKeys(array &$array)
    {
        $array = array_values($array);
    }

}
