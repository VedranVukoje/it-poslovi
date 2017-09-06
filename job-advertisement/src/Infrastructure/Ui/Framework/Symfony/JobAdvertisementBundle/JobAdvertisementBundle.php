<?php

/*
 *  ItPoslovi
 *  Vedran Vukoje Ja:
 *  vedran.vukoje@gmail.com
 */


namespace JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\DependencyInjection\Compiler\EventDispatcherCompilerPass;
use JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\DependencyInjection\Compiler\ItPosloviTransactionCompailerPass;
/**
 * Description of JobAdvertisementBundle
 * JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\JobAdvertisementBundle
 * @author vedran
 */
class JobAdvertisementBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new EventDispatcherCompilerPass());
    }
}
