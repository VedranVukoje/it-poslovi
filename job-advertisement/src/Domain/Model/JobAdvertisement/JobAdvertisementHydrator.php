<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement;

use DateTimeImmutable;
use JobAd\Domain\Model\JobAdvertisement\Exceptions\HydrationException;
use JobAd\Domain\Model\Tag\Tag;
use JobAd\Domain\Model\Tag\Adapter\TagCollection;
use JobAd\Domain\Model\Location\City;
use JobAd\Domain\Model\Location\PostCode;
use JobAd\Domain\Model\Category\Category;
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;

/**
 * Description of JobAdvertisementHydrator
 *
 * @author vedran
 */
class JobAdvertisementHydrator extends JobAdvertisement implements JobAdvertisementHydratorInterface
{

    public function extract(JobAdvertisement $jobAd): array
    {
        $categoryes = iterator_to_array($jobAd->categoryes->map(function($category){
            return ['id' => (string) $category->id(), 'name' => (string) $category->name()];
        }));
        
        $typeOfJobs = iterator_to_array($jobAd->typeOfJobs->map(function($typeOfJob){
            return ['id' => (string) $typeOfJob->id(), 'name' => (string) $typeOfJob->name()];
        }));
        
        $tags = iterator_to_array($jobAd->tags->map(function($tag){
            return ['id' => (string) $tag->id(), 'name' => (string) $tag->name()];
        }));
        
        return [
            'id' => (string) $jobAd->id(),
            'version' => $this->version,
            'pozitonTitle' => (string) $jobAd->pozitonTitle,
            'description' => (string) $jobAd->description,
            'howToApply' => (string) $jobAd->howToApply,
            'categoryes' => $categoryes,
            'city' => [
                'name' => (string) $jobAd->city,
                'postCode' => is_null($jobAd->city)? '': (string) $jobAd->city->postCode() 
                ],
            'typeOfJobs' => $typeOfJobs,
            'status' => (string) $jobAd->status,
            'end' => is_null($jobAd->end)? null:$jobAd->end->format('d.m.Y'),
            'tags' => $tags,
            'createdAt' => $jobAd->createdAt ? $jobAd->createdAt->format('d.m.Y H:i:s') : null,
            'updatedAt' => $jobAd->updatedAt ? $jobAd->updatedAt->format('d.m.Y H:i:s') : null
        ];
    }
    
    /**
     * 
     * @todo istrazi refleksiju ... bindTo .... ili u JobAdvertisement protected setPozitionTitle() ???
     * 
     * @param array $data
     * @param \JobAd\Domain\Model\JobAdvertisement\JobAdvertisement $jobAd
     * @return \JobAd\Domain\Model\JobAdvertisement\JobAdvertisement
     * @throws HydrationException
     */
    public function hydrate(array $data, JobAdvertisement $jobAd): JobAdvertisement
    {
        if (0 == count($data)) {
            throw new HydrationException(sprintf('Vrednost $data za hidriranje nije prosleden u %s::hydrate.', self::class));
        }

        $propertiesNames = array_keys(get_object_vars($this));
        $hydratorDataKeys = array_keys($data);

        if (0 == array_intersect($propertiesNames, $hydratorDataKeys)) {
            throw new HydrationException(sprintf('$data ne sadrzi sve vrednosti za hidriranje.', implode(',', $hydratorDataKeys)));
        }

        $jobAd->pozitonTitle = new PozitonTitle($data['pozitonTitle']);
        $jobAd->description = new Description($data['description']);
        $jobAd->howToApply = new HowToApply($data['howToApply']);
        $jobAd->typeOfJobs = new TypeOfJobCollection(array_map(function($data) {
                    return TypeOfJob::hydrate($data);
                }, $data['typeOfJobs']));
        $jobAd->categoryes = new CategoryCollection(array_map(function($data) {
                    return Category::hydrate($data);
                }, $data['categoryes']));
        if (isset($data['city']['postCode']) && !empty($data['city']['postCode'])) {
            $jobAd->city = new City(new PostCode((int)$data['city']['postCode']), $data['city']['name']);
        }

        $jobAd->tags = new TagCollection(array_map(function($data) {
                    return Tag::hydrate($data);
                }, $data['tags']));

        $jobAd->end = new DateTimeImmutable($data['end']);
        
        $jobAd->status = Status::fromNative($data['status']);
        
//        dump($data);

        $jobAd->updatedAt = new DateTimeImmutable($data['updatedAt']);
        $jobAd->createdAt = new DateTimeImmutable($data['createdAt']);
            
        return $jobAd;
    }

//    return [
//            'index' => 'it-poslovi',
////            'type' => 'job-advertisement', // pazi na ovo vec imas dole pise...
//            'body' => [
//                'mappings' => [
//                    'job-advertisement' => [
//                        '_all' => ["enabled" => false],
//                        'properties' => [
//                            'id' => ['type' => 'string'],
//                            'pozitonTitle' => ['type' => 'string'],
//                            'description' => ['type' => 'text'],
//                            'howtoapplay' => ['type' => 'text'],
//                            'typeofjobs' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'categoryes' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'city' => ['properties' => ['postCode' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'tags' => ['properties' => ['id' => ['type' => 'string'], 'name' => ['type' => 'string']]],
//                            'end' => ['type' => 'date', 'format' => 'dd.MM.yyyy'],
//                            'status' => ['type' => 'short'],
//                            'updatedAt' => ['type' => 'date', 'format' => 'dd.MM.yyyy HH:mm:ss'],
//                            'createdAt' => ['type' => 'date', 'format' => 'dd.MM.yyyy HH:mm:ss']
//                        ]
//                    ]
//                ]
//            ]
//        ];


    public function __construct()
    {
        
    }

}
