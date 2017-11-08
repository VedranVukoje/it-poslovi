<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use JobAd\Infrastructure\Persistence\ElasticSearch\MessageDomainEventProcessing;
/**
 * Description of MessageDomainEventProcessingPass
 *
 * @author vedran
 */
class MessageDomainEventProcessingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        
        $id = MessageDomainEventProcessing::class;
        
        if (!$container->has($id)) {
            return;
        }
        
        $definition = $container->findDefinition($id);

        $subscribers = $container->findTaggedServiceIds('app.message.domain.event.processing');

        foreach ($subscribers as $id => $tag) {
            $definition->addMethodCall('subscribe', [new Reference($id)]);
        }
    }
}
