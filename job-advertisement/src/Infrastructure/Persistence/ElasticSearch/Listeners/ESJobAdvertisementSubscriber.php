<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\ElasticSearch\Listeners;

use Psr\Log\LoggerInterface;
use JobAd\Domain\EventSubscriber;
use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdWasDrafted;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdDescriptionsWasManaged;
use JobAd\Domain\Model\JobAdvertisement\Events\TypeOfJobWasAddedToJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\TypeOfJobWasRemovedFromJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\CategoryWasAddToJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\CategoryWasRemoveFromJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\CityWasAddedToJobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Events\DurationWasAddedToAd;
use JobAd\Domain\Model\JobAdvertisement\Events\TagWasAddedToJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\TagWasRemovedFromJobAd;

/**
 * Description of ESJobAdvertisementSubscriber
 * 
 * @author vedran
 */
class ESJobAdvertisementSubscriber implements EventSubscriber
{

    const DRAFTED = 0;

    private $events = [
        JobAdWasDrafted::class,
        JobAdDescriptionsWasManaged::class,
        TypeOfJobWasAddedToJobAd::class,
        TypeOfJobWasRemovedFromJobAd::class,
        CategoryWasAddToJobAd::class,
        CategoryWasRemoveFromJobAd::class,
        CityWasAddedToJobAdvertisement::class,
        DurationWasAddedToAd::class,
        TagWasAddedToJobAd::class,
        TagWasRemovedFromJobAd::class
    ];
    private $repo;
    
    private $logger;
    
    private $method;

    public function __construct(JobAdvertisementRepository $repo, LoggerInterface $logger)
    {
        $this->repo = $repo;
        $this->logger = $logger;
    }

    public function isSubscribedTo(DomainEvent $event)
    {
        return in_array(get_class($event), $this->events);
    }

    public function handle(DomainEvent $event)
    {
        $mamespace = explode('\\', get_class($event));
        $method = lcfirst(array_pop($mamespace));

        if (!method_exists($this, $method)) {
            throw new BadMethodCallException(sprintf('Dogadjaj "%s" nije registrovan.', $method));
        }
        $this->method = $method;
        $this->$method($event);
    }

    protected function jobAdWasDrafted(JobAdWasDrafted $event)
    {
        $this->add($this->jobAd($event));
    }

    private function jobAdDescriptionsWasManaged(JobAdDescriptionsWasManaged $event)
    {
        $this->add($this->ofId($event));
    }

    private function typeOfJobWasAddedToJobAd(TypeOfJobWasAddedToJobAd $event)
    {
        $this->add($this->ofId($event));
    }

    private function typeOfJobWasRemovedFromJobAd(TypeOfJobWasRemovedFromJobAd $event)
    {
        $this->add($this->ofId($event));
    }

    private function categoryWasAddToJobAd(CategoryWasAddToJobAd $event)
    {
        $this->add($this->ofId($event));
    }

    private function categoryWasRemoveFromJobAd(CategoryWasRemoveFromJobAd $event)
    {
        $this->add($this->ofId($event));
    }

    private function cityWasAddedToJobAdvertisement(CityWasAddedToJobAdvertisement $event)
    {
        $this->add($this->ofId($event));
    }

    private function durationWasAddedToAd(DurationWasAddedToAd $event)
    {
        $this->add($this->ofId($event));
    }

    private function tagWasAddedToJobAd(TagWasAddedToJobAd $event)
    {
        $this->add($this->ofId($event));
    }
    
    private function tagWasRemovedFromJobAd(TagWasRemovedFromJobAd $event)
    {
        $this->add($this->ofId($event));
    }

    private function add(JobAdvertisement $jobAd)
    {
        $this->repo->add($jobAd);
    }

    private function ofId(DomainEvent $event)
    {
        return $this->repo->ofId(Id::fromNative($event->id()))->doApplayByDomainEvent($event);
    }

    private function jobAd(DomainEvent $event)
    {
        return (new JobAdvertisement(Id::fromNative($event->id())))->doApplayByDomainEvent($event);
    }

}
