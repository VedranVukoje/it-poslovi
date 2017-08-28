<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
//use Symfony\Component\HttpKernel\Event\GetResponseEvent;
//use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
//use Symfony\Component\HttpKernel\Event\;
use Symfony\Component\HttpKernel\KernelEvents;

use JobAd\Application\Event\EventDispatcher;

/**
 * Description of EventDispecerSubscriber
 * 
 * 
 * @todo Nisam bas siguran da ovo moze 'vako. Obrati paznju da konstruktor .
 * U njemu inicijalizujes EventDipatcar za Symfony na KernelEvents::CONTROLLER. 
 * Mozda ima bolje resenje . Istrazi
 * 
 * @author vedran
 */
class ItPosloviBootSubscriber implements EventSubscriberInterface
{
    
    private $dispatcher;
    
    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [
                ['addSubscribers']
            ]
        ];
    }
    
    public function addSubscribers(FilterControllerEvent $event)
    {
        
    }
}
