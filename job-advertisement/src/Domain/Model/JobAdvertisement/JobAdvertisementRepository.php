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
interface JobAdvertisementRepository
{
    public function nextIdentity();
    public function ofId(Id $id, int $version): JobAdvertisement;
    public function add(JobAdvertisement $jobAdvertisement);
    public function query($specification);
}
