<?php

namespace Backoffice\FrameworkBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Description of SubmitJsonListener
 *
 */
class SubmitJsonListener
{

    public function onKernelRequest(GetResponseEvent $event)
    {


        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $hasBeenSubmited = in_array($request->getMethod(), ['POST', 'PUT'], true);
        $isJson = 'application/json; charset=UTF-8' == $request->headers->get('Content-Type');

        if (!$hasBeenSubmited || !$isJson) return;
        $data = json_decode($request->getContent(), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            $event->setResponse(new JsonResponse(['error' => 'Invalid or malformed JSON']), 400);
        }

        $request->request->add($data ? : [] );
    }

}
