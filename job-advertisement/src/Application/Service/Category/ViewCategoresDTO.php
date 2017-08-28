<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\Category;

use JobAd\Domain\Collection;
/**
 * Description of ViewCategoresDTO
 *
 * @author vedran
 */
class ViewCategoresDTO
{
    
    public $categoryes;


    public function __construct(Collection $categoryes)
    {
        
        $this->categoryes = iterator_to_array($categoryes->map(function($category){
            return ['id' => (string) $category->id(), 'name' => (string) $category->name()];
        }));
    }
}
