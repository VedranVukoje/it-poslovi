<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain;

use JobAd\Application\Event\EventDispatcher;
/**
 * Description of HasEvents
 *
 * @author vedran
 */
trait HasEvents
{

    protected $events = [];
    
    public function record($event)
    {
        EventDispatcher::instance()->publish($event);
        $this->events[] = $event;
    }
    
    public function release()
    {
        $events = $this->events;
        $this->events = [];
        
        return $events;
    }

}
