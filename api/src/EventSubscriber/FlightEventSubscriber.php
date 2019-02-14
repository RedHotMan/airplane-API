<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Flight;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Faker;

final class FlightEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createFlight', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function createFlight(GetResponseForControllerResultEvent $event)
    {
        $faker = Faker\Factory::create();
        $flight = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$flight instanceof Flight || Request::METHOD_POST !== $method) {
            return;
        }

        $flight->setNumber($faker->randomNumber(4));
    }
}