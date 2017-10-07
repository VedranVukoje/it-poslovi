<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Application\Serialization\JMS\TypeHandler;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\VisitorInterface;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;

/**
 * Description of TypeOfJobCollectionHandler
 *
 * @author vedran
 */
class TypeOfJobCollectionHandler implements SubscribingHandlerInterface
{
    const TYPE = 'TypeOfJobCollection';
    
    /**
     * @return string[][]
     */
    public static function getSubscribingMethods()
    {
            $formats = [
                    'json',
                    'xml',
                    'yml',
            ];
            $methods = [];
            foreach ($formats as $format) {
                    $methods[] = [
                            'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                            'type' => self::TYPE,
                            'format' => $format,
                            'method' => 'serialize',
                    ];
                    $methods[] = [
                            'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                            'type' => self::TYPE,
                            'format' => $format,
                            'method' => 'deserialize',
                    ];
            }

            return $methods;
    }
    
    public function serialize(VisitorInterface $visitor, TypeOfJobCollection $data, array $type, Context $context)
    {
        $typeOfJobs = iterator_to_array($data->map(function($typeOfJob){
            return $typeOfJob->extract();
        }));
        
        return $visitor->visitArray($typeOfJobs, $type, $context);
    }
    
    public function deserialize(VisitorInterface $visitor, array $data, array $type, Context $context)
    {
        return new TypeOfJobCollection(array_map(function($data){
            return TypeOfJob::hydrate($data);
        }, $data));
    }
}
