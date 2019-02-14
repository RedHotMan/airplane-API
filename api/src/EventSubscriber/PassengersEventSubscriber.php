<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Passenger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PassengersEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createPassenger', EventPriorities::POST_VALIDATE],
        ];
    }

    public function createPassenger(GetResponseForControllerResultEvent $event)
    {
        $passenger = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$passenger instanceof Passenger || Request::METHOD_POST !== $method) {
            return;
        }

        $gender = $passenger->getGender();

        if ($gender === null)
        {
            $passenger->setGender(false);
        }
    }
}