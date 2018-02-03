<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch\Mapping;

/**
 * Description of JobAdvertisementMap
 *
 * @todo nije jos gotovo.... comand ... bla ....
 * ItPosloviElasticSearchTypeMapping
 * @author vedran
 */
class JobAdvertisementMapping
{

    public function map()
    {
        return [
            'index' => 'it-poslovi',
//            'type' => 'job-advertisement', // pazi na ovo vec imas dole pise...
            'body' => [
                'mappings' => [
                    'job-advertisement' => [
                        '_all' => ["enabled" => false],
                        'properties' => [
                            'id' => ['type' => 'string'],
                            'pozitonTitle' => ['type' => 'string'],
                            'description' => ['type' => 'text'],
                            'howToApply' => ['type' => 'text'],
                            'typeOfJobs' => ['type' => 'nested','properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                            'categoryes' => ['type' => 'nested','properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                            'city' => ['properties' => ['postCode' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                            'tags' => ['type' => 'nested','properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                            'end' => ['type' => 'date', 'format' => 'dd.MM.yyyy'],
                            'status' => ['type' => 'short'],
                            'updatedAt' => ['type' => 'date', 'format' => 'dd.MM.yyyy HH:mm:ss'],
                            'createdAt' => ['type' => 'date', 'format' => 'dd.MM.yyyy HH:mm:ss']
                        ]
                    ]
                ]
            ]
        ];
    }

    public function mappings()
    {
        return [
            'index' => 'it-poslovi',
            'type' => 'job-advertisement',
            'body' => [
                'job-advertisement' => [
                    '_all' => ["enabled" => false],
                    'properties' => [
                        'id' => ['type' => 'string'],
                        'pozitonTitle' => ['type' => 'string'],
                        'description' => ['type' => 'text'],
                        'howToApply' => ['type' => 'text'],
                        'typeOfJobs' => ['type' => 'nested','properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                        'categoryes' => ['type' => 'nested', 'properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                        'city' => ['properties' => ['postcode' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                        'tags' => ['type' => 'nested','properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                        'end' => ['type' => 'date', 'format' => 'dd.MM.yyyy'],
                        'status' => ['type' => 'short'],
                        'updatedAt' => ['type' => 'date', 'format' => 'dd.MM.yyyy HH:mm:ss'],
                        'createdAt' => ['type' => 'date', 'format' => 'dd.MM.yyyy HH:mm:ss']
                    ]
                ]
        ]];
    }

}

// curl -XPUT 'localhost:9200/website/blog/1?version=1&pretty' -H 'Content-Type: application/json' -d'
//{
//  "title": "My first blog entry",
//  "text":  "Starting to get the hang of this..."
//}
//'

//        $client = \Elasticsearch\ClientBuilder::create()->build();

//        $esData = [
//            'index' => 'itposlovi',
////            'type' => 'jobadvertisment',
////            'id' => $draftResponse->id,
//            'body' => [
//                'mappings' => [
//                    'jobadvertisment' => [
//                        '_all' => ["enabled" => false],
//                        'properties' => [
//                            'id' => ['type' => 'string'],
//                            'pozitonTitle' => ['type' => 'string'],
//                            'description' => ['type' => 'text'],
//                            'howtoapplay' => ['type' => 'text'],
//                            'typeofjobs' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'categoryes' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'city' => ['properties' => ['postcode' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'status' => ['type' => 'text']
//                        ]
//                    ]
//                ]
//            ]
//        ];

//        $esData = [
//            'index' => 'itposlovi',
//            'type' => 'jobadvertisment',
//            'body' => [
//                'jobadvertisment' => [
////                        '_all' => ["enabled" => false],
//                    'properties' => [
////                            'id' => ['type' => 'string'],
////                            'pozitonTitle' => ['type' => 'string'],
////                            'description' => ['type' => 'text'],
////                            'howtoapplay' => ['type' => 'text'],
////                            'typeofjobs' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
////                            'categoryes' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
////                            'city' => ['properties' => ['postcode' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                        'status' => ['type' => 'text']
//                    ]
//                ]
//            ]
//        ];
//        $client->indices()->putMapping($esData);
//        $client->indices()->putSettings($esData);
//        $client->indices()->create($esData);
//        $client->index($esData);
//        $client->create($esData);
//        $client;
//        dump($esData);
