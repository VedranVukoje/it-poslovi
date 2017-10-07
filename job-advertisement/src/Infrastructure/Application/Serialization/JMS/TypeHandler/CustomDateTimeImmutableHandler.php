<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Application\Serialization\JMS\TypeHandler;

use DateTimeImmutable;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
//use JMS\Serializer\AbstractVisitor;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
//use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\VisitorInterface;

/**
 * Description of DateTimeImmutableHandler
 *
 * @author vedran
 */
class CustomDateTimeImmutableHandler implements SubscribingHandlerInterface
{
    
    const TYPE = 'CustomDateTimeImmutable';
    
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
    
    public function serialize(VisitorInterface $visitor, DateTimeImmutable $data, array $type, Context $context)
    {
        return $visitor->visitString($data->format('d.m.Y H:i:s'), $type, $context);
    }
    
    public function deserialize(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        return new DateTimeImmutable($data);
    }
}
