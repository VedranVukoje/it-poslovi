<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Location;

//use JobAd\Domain\Collection;
/**
 *
 * @author vedran
 */
interface CityRepository
{
    public function byPostCode(PostCode $postcode): City;
    public function query($specification);
}
