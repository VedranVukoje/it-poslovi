<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\TypeOfJob;

/**
 *
 * @author vedran
 */
interface TypeOfJobHydratorInterface
{
    public function extract(TypeOfJob $typeOfJob): array;
    public function hydrate(array $data, TypeOfJob $typeOfJob): TypeOfJob;
}
