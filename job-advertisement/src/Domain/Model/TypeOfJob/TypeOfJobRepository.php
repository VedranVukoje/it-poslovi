<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\TypeOfJob;

use JobAd\Domain\Collection;
/**
 * Description of TypeOfJobReposytory
 *
 * @author vedran
 */
interface TypeOfJobRepository
{
    public function nextIdentity();
    public function add(TypeOfJob $type_of_job);
    public function query($specification): Collection;
    
}
