<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\TypeOfJob;

use JobAd\Domain\Collection;

/**
 * Description of ViewTypeOfJobArrayResponse
 *
 * @author vedran
 */
class ViewTypeOfJobArrayCollectionResponse
{

    public $typeOfJobs;

    public function assemble(Collection $typeOfJobs)
    {
        // 2017-07-17 18:50:59
        $this->typeOfJobs = iterator_to_array($typeOfJobs->map(function($typeOfJob) {
                    return [
                        'id' => (string) $typeOfJob->id(),
                        'name' => (string) $typeOfJob->name(),
                        'createdAt' => $typeOfJob->createdAt()->format("Y-m-d H:m:i"),
                        'updatedAt' => $typeOfJob->updatedAt()->format("Y-m-d H:m:i")
                    ];
                }));


        return $this;
    }

}
