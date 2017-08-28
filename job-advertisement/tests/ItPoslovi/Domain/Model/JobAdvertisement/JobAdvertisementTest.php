<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ItPosloviTests\Domain\Model\JobAdvertisement;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Name;
use JobAd\Domain\Model\JobAdvertisement\Description;
use JobAd\Domain\Model\JobAdvertisement\HowToApplay;
/**
 * Description of JobAdvertisementTest
 *
 * @author vedran
 */
class JobAdvertisementTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * smrc smrc smrc buahh.....
     * 
     * @test
     */
    public function shouldDraftJobAd()
    {
       $draft = JobAdvertisement::draftAd(new Name('Name'), new Description('description'), new HowToApplay('how to applay .')); 
        
       $this->assertTrue(true);
    }
}
