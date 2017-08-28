<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\JobAdvertisement;

/**
 * Description of TestByMe
 *
 * @author vedran
 */
class TestByMe
{
    private $callable;
    
    public function __construct(callable $callable = null)
    {
        $this->callable = $callable;
    }
    
    public function __invoke(array $array = [])
    {
        $callable = $this->callable;
        
        return new static($callable($array));
    }
}
