<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Adapter;

use JobAd\Application\Contract\Logbook;
use Psr\Log\LoggerInterface;

/**
 * Description of Logger
 *
 * @author vedran
 */
class Monolog implements Logbook {
    
    private $logger;
    
    public function __construct(LoggerInterface $logger) {
        
        $this->logger = $logger;
        
    }
    
    public function info($message, array $context = [])
    {
        $this->logger->info($message, $context);
    }
    
}
