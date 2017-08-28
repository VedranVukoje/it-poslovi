<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\TypeOfJob;

use ReflectionClass;
/**
 * Description of StatusNames
 *
 * @author vedran
 */
class StatusNames
{
    
    public static function datat()
    {
        $status = (new ReflectionClass(Status::class))->getConstants();
        return array_map(function($value){
                        return ucfirst(strtolower($value));
                    }, array_flip($status));
    }
    
}
