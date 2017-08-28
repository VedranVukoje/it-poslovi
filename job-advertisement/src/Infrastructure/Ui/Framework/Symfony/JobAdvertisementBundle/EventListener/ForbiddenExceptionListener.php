<?php

namespace Backoffice\FrameworkBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Description of ForbiddenExceptionListener
 *
 * @author vedran
 */
class ForbiddenExceptionListener {
    
    public function onKernelException(GetResponseForExceptionEvent $event){
        
        $exeption = $event->getException();
        
        if ( !$exeption instanceof AccessDeniedException ){
            return;
        }
        
        $event->setResponse(new JsonResponse(['error' => 'The credentials are either missing or incorrect'], 403));
    }
    
}
