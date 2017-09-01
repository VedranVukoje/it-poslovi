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
use JobAd\Domain\DomainEventPublisher;
/**
 * Description of EventDispatcherCompilerPass
 *
 * @author vedran
 */
class EventDispatcherCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        
        $id = DomainEventPublisher::class;
        
        if (!$container->has($id)) {
            return;
        }
        
        $definition = $container->findDefinition($id);

        $subscribers = $container->findTaggedServiceIds('app.domain.subscriber');

        foreach ($subscribers as $id => $tag) {
            $definition->addMethodCall('subscribe', [new Reference($id)]);
        }
    }

}
