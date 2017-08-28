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

use JobAd\Application\Service\Transaction;
/**
 * Description of DraftJobAdCompailerPass
 *
 * @author vedran
 */
class ItPosloviTransactionCompailerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $id = Transaction::class;
        
        if(!$container->has($id)){
            return;
        }
        
        $definition = $container->getDefinition($id);
        
        $taggedServices = $container->findTaggedServiceIds('application.service');
        
        $draft = [
            'it_poslovi.draft_job',
            'it_poslovi.typeofjob.view',
            'it_poslovi.view_city'
        ];
        
        foreach ($taggedServices as $id => $attrigutes){
//            dump($id); // it_poslovi.draft_job it_poslovi.typeofjob.view it_poslovi.view_city 
//            
//            dump($attrigutes);
            
        }
        
    }
    
}
