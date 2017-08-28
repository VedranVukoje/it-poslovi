<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\EventListener;

use JobAd\Domain\DomainEventPublisher;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
/**
 * Description of InstanceDomainEvnetDispatcherListner
 *
 * @author vedran
 */
class InstanceDomainEvnetPublisher
{
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        DomainEventPublisher::instance();
    }
}
