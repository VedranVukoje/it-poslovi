<?php

namespace ItPosloviTests\Domain\Model\TypeOfJob;

use Ramsey\Uuid\Uuid;
use JobAd\Domain\Model\TypeOfJob\Id;

/**
 * Description of IdTest
 *
 * @author vedran
 */
class IdTest extends \PHPUnit_Framework_TestCase
{

//    public function shouldRequireInstanceOfUuid()
//    {
//        $this->setExpectedException(get_class(new \PHPUnit_Framework_Error("", 0, "", 1)));
//        $id = new Id;
//    }

    /**
     * @test
     */
    public function shouldCreateId()
    {
        $id = new Id(Uuid::uuid4());
        $this->assertInstanceOf(Id::class, $id);
    }

    /**
     * @test
     */
    public function shouldGenerateId()
    {
        $id = Id::generate();
        $this->assertInstanceOf(Id::class, $id);
    }

    /**
     * @test
     */
    public function shouldCreateIdFromString()
    {
        $id = Id::fromNative('e17f9e62-6839-4761-aafd-912da44c056c');
        $this->assertInstanceOf(Id::class, $id);
    }

    /**
     * @test
     */
    public function shouldTestEquality()
    {
        $one = Id::fromNative('e17f9e62-6839-4761-aafd-912da44c056c');
        $two = Id::fromNative('e17f9e62-6839-4761-aafd-912da44c056c');
        $three = Id::generate();

        $this->assertTrue($one->equals($two));
        $this->assertFalse($one->equals($three));
    }

}
