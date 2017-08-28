<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ItPosloviTests\Domain\Model\TypeOfJob;

use JobAd\Domain\Model\TypeOfJob\Status;
use JobAd\Domain\Model\TypeOfJob\StatusNames;
/**
 * Description of StatusTest
 *
 * @author vedran
 */
class StatusTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldBeThrowException()
    {
        Status::fromNative();
    }
    
    /**
     * @test
     */
    public function shouldBeActiveStatus()
    {
        $active = Status::active();
        $this->assertInstanceOf(Status::class,$active);
        $this->assertTrue($active->equals(Status::active()));
        $this->assertFalse($active->equals(Status::block()));
        $this->assertTrue($active->equals(Status::fromNative(2)));
        $this->assertEquals("2", (string) $active);
    }
    /**
     * @test
     */
    public function shouldBeBlockStatus()
    {
        $block = Status::block();
        $this->assertInstanceOf(Status::class,$block);
        $this->assertTrue($block->equals(Status::block()));
        $this->assertFalse($block->equals(Status::active()));
        $this->assertTrue($block->equals(Status::fromNative(1)));
        $this->assertEquals("1", (string) $block);
    }
    
    
    
}
