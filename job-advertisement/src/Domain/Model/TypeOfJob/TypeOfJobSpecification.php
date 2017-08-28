<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\TypeOfJob;

use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
/**
 *
 * @author vedran
 */
interface TypeOfJobSpecification
{
    /**
     * @todo da bude public function specifies(TypeOfJobRepository $typeOfJob)
     * @param type $typeOfJob
     */
    public function specifies(TypeOfJobRepository $typeOfJob);
}
