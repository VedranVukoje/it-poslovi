<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service;

/**
 * Description of BaseResponse
 * implemant ArrayAcces i ... da moze da se iteruje i $z['x'] = neki....
 * @author vedran
 */
class BaseResponse implements ApplicationService
{
    private $response = [];
    
    public function __construct(array $response = [])
    {
        $this->response = $response;
    }
    
    /**
     * @todo prebaci u staticku . muva burazeru ....
     * @param string $key
     * @param type $value
     * @return $this
     */
    public function set(string $key, $value)
    {
        $this->response[$key] = $value;
        
        return $this;
    }
    
    public function get(string $key)
    {
        /**
         * @todo provera ako nema kljuca 
         */
        return $this->response[$key];
    }


    public function response()
    {
        return $this->response;
    }

    public function execute($request = null)
    {
        return new static;
    }
    
    
    
}
