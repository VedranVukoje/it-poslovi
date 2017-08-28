<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service;

/**
 * Description of ServiceApplicationDecorator
 *
 * @author vedran
 */
abstract class ServiceApplicationDecorator
{
    
    protected $decorate = [];
    
    
    public function decorate()
    {
        return $this->decorate;
    }
    
}