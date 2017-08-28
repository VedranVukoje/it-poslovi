<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\Location;

use JobAd\Domain\Collection;

/**
 * Description of ViewCityFormResponse
 *
 * @author vedran
 */
class ViewCitiesFormResponse
{

    public $cities = [];

    public function assemble(Collection $collection)
    {
        $this->cities = iterator_to_array($collection->map(function($city) {
                    return ['postCode' => (string) $city->postCode(), 'name' => (string) $city];
                }));

        return $this;
    }

}
