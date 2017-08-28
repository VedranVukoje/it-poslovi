<?php

namespace JobAd\Domain\Model\TypeOfJob;

use JobAd\Domain\AggregateRoot;
use DateTimeImmutable;
use JobAd\Domain\Model\TypeOfJob\Events\TypeOfJobWasCreatedAsActive;

/**
 * Description of TypeOfJob
 *
 * @author vedran
 * 
 *  implements AggregateRoot
 */
class TypeOfJob extends AggregateRoot
{

    /**
     *
     * @var Id
     */
    protected $id;

    /**
     *
     * @var Name
     */
    protected $name;

    /**
     *
     * @var Status
     */
    protected $status;

    /**
     *
     * @var DateTimeImmutable 
     */
    protected $createdAt;

    /**
     *
     * @var DateTimeImmutable
     */
    protected $updatedAt;

    /**
     *
     * @var JobAd\Domain\Model\JobAdvertisement\JobAdvertisement
     */
    protected $jobAdvertisement;

    public function __construct(Id $id)
    {
        $this->id = $id;
    }

    public static function writeNewTypeOfJob(Name $name)
    {
        $oTypeOfJob = new static(Id::generate());
        $oTypeOfJob->newTypeOfJob($name);
        $oTypeOfJob->setStatus(Status::active());
        $oTypeOfJob->updateTimestam();

        return $oTypeOfJob;
    }

    public function manage(Name $name, Status $status)
    {
        $this->name = $name;
        $this->setStatus($status);
        $this->updateTimestam();
    }

    public static function creteAsActive(string $id, string $name, string $createdAt, string $updatedAt): self
    {
        $typeOfJob = new static(Id::fromNative($id));

        $typeOfJob->applayTaht(new TypeOfJobWasCreatedAsActive(
                $typeOfJob->id(), new Name($name), new DateTimeImmutable($createdAt), new DateTimeImmutable($createdAt)));
        
        return $typeOfJob;
    }

    public static function fromIdAndName(string $id, string $name): self
    {
        $typeOfJob = new static(Id::fromNative($id));
        $typeOfJob->name = new Name($name);

        return $typeOfJob;
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function active()
    {
        $this->setStatus(Status::active());
    }

    public function block()
    {
        $this->setStatus(Status::alock());
    }

    public function delete()
    {
        $this->setStatus(Status::Delete());
    }

    public function status()
    {
        return $this->status;
    }
    
    public function updateTimestam()
    {
        $this->updatedAt = new \DateTimeImmutable();

        if (null === $this->createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }
    
    public function createdAt()
    {
        return $this->updatedAt;
    }
    
    public function updatedAt()
    {
        return $this->updatedAt;
    }

    public function jobAdvertisement()
    {
        return $this->jobAdvertisement;
    }

    public function isActive()
    {
        return $this->status->equals(Status::active());
    }

    public function isBlock()
    {
        return $this->status->equals(Status::block());
    }

    public function isDeleted()
    {
        return $this->status->equals(Status::delete());
    }

    protected function newTypeOfJob(Name $name)
    {
        $this->name = $name;
        $this->setStatus(Status::active());
    }
    
    protected function applyTypeOfJobWasCreatedAsActive(TypeOfJobWasCreatedAsActive $event)
    {
        $this->id = $event->id();
        $this->name = $event->name();
        $this->setStatus(Status::active());
        $this->createdAt = $event->createdAt();
        $this->updatedAt = $event->updatedAt();
    }
    
    private function setStatus(Status $status)
    {
        $this->status = $status;
    }
}
