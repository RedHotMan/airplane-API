<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Personal;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PeronalEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createPersonal', EventPriorities::POST_VALIDATE],
        ];
    }

    public function createPersonal(GetResponseForControllerResultEvent $event)
    {
        $personal = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$personal instanceof Personal || Request::METHOD_POST !== $method) {
            return;
        }

        $personal->setFunction(ucfirst($personal->getFunction()));
    }
}