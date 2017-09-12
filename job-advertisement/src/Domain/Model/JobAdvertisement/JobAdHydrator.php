<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\JobAdvertisement;

/**
 *
 * @author vedran
 */
interface JobAdHydrator
{
    public function extract(JobAdvertisement $jobAd): array;
    public function hydrate(array $data, JobAdvertisement $jobAd): JobAdvertisement;
}
