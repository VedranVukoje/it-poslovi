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
use JobAd\Domain\Model\Tag\Tag;
use JobAd\Domain\Model\Tag\Adapter\TagCollection;
/**
 * Description of TagCollectionHandler
 *
 * @author vedran
 */
class TagCollectionHandler implements SubscribingHandlerInterface
{
    const TYPE = 'TagCollection';
    
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
    
    public function serialize(VisitorInterface $visitor, TagCollection $data, array $type, Context $context)
    {
        $data = iterator_to_array($data->map(function($data){
            return $data->extract();
        }));
        
        return $visitor->visitArray($data, $type, $context);
    }
    
    public function deserialize(VisitorInterface $visitor, array $data, array $type, Context $context)
    {
        return new TagCollection(array_map(function($data){
            return Tag::hydrate($data);
        }, $data));
    }
}
