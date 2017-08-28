<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\TypeOfJob;

use JobAd\Domain\Comand;
/**
 * Description of NewTypeOfJobRequst is DTO .
 *
 * @author vedran
 */
class NewTypeOfJobComand implements Comand
{
    private $name;
    
    public function __construct($name)
    {
        $this->name = $name;
    }
    
    public function name()
    {
        return $this->name;
    }
}
