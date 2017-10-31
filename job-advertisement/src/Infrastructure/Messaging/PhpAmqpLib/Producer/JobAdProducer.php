<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
namespace JobAd\Infrastructure\Messaging\PhpAmqpLib\Producer;

use JobAd\Application\Contract\Messaging;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
/**
 * Description of JobAdProducer
 * 
 * @author vedran
 */
class JobAdProducer extends Producer implements Messaging
{
    protected $contentType = 'application/json';
    protected $deliveryMode = 2;
    
}
