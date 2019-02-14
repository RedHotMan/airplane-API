<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Plane;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Faker;

final class PlaneEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createPlane', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function createPlane(GetResponseForControllerResultEvent $event)
    {
        $faker = Faker\Factory::create();
        $plane = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$plane instanceof Plane || Request::METHOD_POST !== $method) {
            return;
        }

        $plane->setNumber($faker->randomNumber(4));
    }
}