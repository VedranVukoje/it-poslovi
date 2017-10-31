<?php

/*
 *  ItPoslovi
 *  Vedran Vukoje Ja:
 *  vedran.vukoje@gmail.com
 */

namespace JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Description of ItPosloviExtension
 *
 * @author vedran
 */
class JobAdvertisementExtension extends Extension
{

    const ALIAS = 'job_advertisement';

    public function load(array $configs, ContainerBuilder $container)
    {

//        dump($configs);
//        $configuration = new Configuration();
//        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        
        $loader->load('serializer.xml');
        
        $loader->load('elasticserach.xml');
        
        $loader->load('rabbitmq.xml');
    }

    public function getAlias()
    {
        return self::ALIAS;
    }

}
