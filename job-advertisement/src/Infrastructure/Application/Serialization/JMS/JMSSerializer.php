<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Application\Serialization\JMS;

use JMS\Serializer\Serializer as ClientSerializer; 
use JobAd\Application\Contract\Serializer;

/**
 * Description of JMSSerializer
 *
 * @author vedran
 */
class JMSSerializer implements Serializer
{

    private $serializer;

    public function __construct(ClientSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize($data, $format)
    {
        return $this->serializer->serialize($data, $format);
    }

    public function deserialize($serializeData, $fqcn, $format)
    {
        return deserialize($serializeData, $fqcn, $format);
    }

}
