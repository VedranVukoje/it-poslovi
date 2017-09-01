<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;


$definitionPopup = new Definition('Backoffice\FrameworkBundle\Templating\Helper\PopupHelper');
$definitionPopup->addTag('templating.helper', ['alias'=>'popup']);
$container->setDefinition('templating.helper.popup', $definitionPopup);

$submitJsonListener = new Definition('Backoffice\FrameworkBundle\EventListener\SubmitJsonListener');
$submitJsonListener->addTag('kernel.event_listener', ['event' => 'kernel.request', 'method' => 'onKernelRequest']);
$container->setDefinition('app.submit_json_listener', $submitJsonListener);

$forbiddenExceptionListener = new Definition('Backoffice\FrameworkBundle\EventListener\ForbiddenExceptionListener');
$forbiddenExceptionListener->addTag('kernel.event_listener', ['event' => 'kernel.exception', 'method' => 'onKernelException', 'priority' => 10]);
$container->setDefinition('app.forbidden_exception_listener', $forbiddenExceptionListener);

/*

$container->setDefinition(
    'backoffice_framework.example',
    new Definition(
        'Backoffice\FrameworkBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);

*/
