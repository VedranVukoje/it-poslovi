<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain;

/**
 *
 * @author vedran
 */
interface EventSubscriber
{
    public function isSubscribedTo(DomainEvent $event);
    public function handle(DomainEvent $event);
}
