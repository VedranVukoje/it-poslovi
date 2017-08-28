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
 * 
 * @author vedran
 */
class JobAdvertisementType
{
    public function map()
    {
        return [
            'index' => 'itposlovi',
//            'type' => 'jobadvertisment', pazi na ovo vec imas dole pise...
            'body' => [
                'mappings' => [
                    'jobadvertisment' => [
                        '_all' => ["enabled" => false],
                        'properties' => [
                            'id' => ['type' => 'string'],
                            'pozitonTitle' => ['type' => 'string'],
                            'description' => ['type' => 'text'],
                            'howtoapplay' => ['type' => 'text'],
                            'typeofjobs' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                            'categoryes' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                            'city' => ['properties' => ['postcode' => ['type' => 'string'], 'name' => ['type' => 'string']]],
                            'status' => ['type' => 'short']
                        ]
                    ]
                ]
            ]
        ];
    }
}

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
