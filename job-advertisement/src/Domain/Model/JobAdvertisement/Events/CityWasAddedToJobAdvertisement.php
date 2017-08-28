<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement\Events;

use DateTimeImmutable;
use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\Location\City;

/**
 * Description of CityWasAddedToJobAdvertisement
 *
 * @author vedran
 */
class CityWasAddedToJobAdvertisement implements DomainEvent
{

    private $id;
    private $city;
    private $occurr;

    public function __construct(Id $id, City $city)
    {
        $this->id = $id;
        $this->city = $city;
        $this->occurr = new DateTimeImmutable();
    }

    public function id()
    {
        return $this->id;
    }

    public function city()
    {
        return $this->city;
    }

    public function occurredOn()
    {
        return $this->occurr;
    }

}
