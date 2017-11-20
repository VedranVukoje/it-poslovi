<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Tests\Domain\Model\JobAdvertisement;

use JobAd\Tests\Models\JobAdBuild;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementHydrator;
use Ramsey\Uuid\Uuid;
/**
 * Description of JobAdvertisementHydratorTest
 *
 * @author vedran
 */
class JobAdvertisementHydratorTest extends \PHPUnit_Framework_TestCase
{
    
    private $jobAd;
    private $hydrator;
    private $categoryes = [];
    
    public function setUp()
    {
        $this->categoryes = [
                    '6449d934-ed47-44e0-b182-3212c7d89bef' => 'Cat 1', 
                    '88a789c0-398b-4300-afde-a8f8a7aff0b0' => 'Cat 2'
                    ];
        $this->jobAd = JobAdBuild::create()
                ->withDescription('Naziv pozicije','Opis','Kako aplicirati')
                ->withCity(11070, 'Novi Beograd')
                ->withThisCategoryes($this->categoryes);
        $this->hydrator = new JobAdvertisementHydrator;
    }


    /**
     * 
     * @test
     */
    public function shouldExtractToToArray()
    {
        $jobAd = $this->jobAd->build();
        
        $extract = $this->hydrator->extract($jobAd);
        
//        $hydrate = $this->hydrator->hydrate($extract, $jobAd);
        
//        $this->assertInstanceOf(JobAdvertisement::class, $jobAd);
        $this->assertSame('Naziv pozicije', $extract['pozitonTitle']);
        $this->assertSame('Opis', $extract['description']);
        $this->assertSame('Kako aplicirati', $extract['howToApply']);
        $this->assertSame('11070', $extract['city']['postCode']);
        $this->assertSame('Novi Beograd', $extract['city']['name']);
        $this->assertEquals(2,count($extract['categoryes']));
        $catOne = $extract['categoryes'][0];
        $catTwo = $extract['categoryes'][1];
        $this->assertSame('6449d934-ed47-44e0-b182-3212c7d89bef', $catOne['id']);
        $this->assertSame('Cat 1', $catOne['name']);
        $this->assertSame('88a789c0-398b-4300-afde-a8f8a7aff0b0', $catTwo['id']);
        $this->assertSame('Cat 2', $catTwo['name']);
        
    }
    
    /**
     * 
     * @test
     */
    public function shouldHydrateToJobAd()
    {
        $jobAd = $this->jobAd->build();
        
        $extract = $this->hydrator->extract($jobAd);
        
        $hydrate = $this->hydrator->hydrate($extract, $jobAd);
        
        $this->assertInstanceOf(JobAdvertisement::class, $hydrate);
        
        $this->assertSame('11070', (string) $hydrate->city()->postCode());
    }
    
}
