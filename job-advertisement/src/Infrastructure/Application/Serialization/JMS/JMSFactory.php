<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Application\Serialization\JMS;

use JMS\Serializer\SerializerBuilder;
use JobAd\Application\Contract\SerializerClient;
/**
 * Description of JMSFactory
 * 
 * JobAd\Infrastructure\Application\Serialization\JMS\JMSFactory
 * 
 * @author vedran
 */
class JMSFactory implements SerializerClient
{
    public static $instance;


    public static function instance()
    {
        if(null == self::$instance){
            self::$instance = SerializerBuilder::create()->build();
        }
        
        return self::$instance;
    }
}
