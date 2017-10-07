<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Application\Serialization\JMS;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Handler\HandlerRegistry;
use JobAd\Application\Contract\SerializerClient;
use Mhujer\JmsSerializer\Uuid\UuidSerializerHandler;
use JobAd\Infrastructure\Application\Serialization\JMS\TypeHandler\CustomDateTimeImmutableHandler;
use JobAd\Infrastructure\Application\Serialization\JMS\TypeHandler\TypeOfJobCollectionHandler;
use JobAd\Infrastructure\Application\Serialization\JMS\TypeHandler\CategoryCollectionHandler;
use JobAd\Infrastructure\Application\Serialization\JMS\TypeHandler\TagCollectionHandler;
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
        if (null == self::$instance) {
            self::$instance = SerializerBuilder::create()
                    ->configureHandlers(function(HandlerRegistry $registry) {
                        $registry->registerSubscribingHandler(new UuidSerializerHandler());
                        $registry->registerSubscribingHandler(new CustomDateTimeImmutableHandler());
                        $registry->registerSubscribingHandler(new TypeOfJobCollectionHandler());
                        $registry->registerSubscribingHandler(new CategoryCollectionHandler());
                        $registry->registerSubscribingHandler(new TagCollectionHandler());
                    })
                    ->addMetadataDir(__DIR__ . '/Config')
                    ->build();
        }

        return self::$instance;
    }

}
