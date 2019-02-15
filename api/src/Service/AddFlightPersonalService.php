<?php

namespace App\Service;

use App\Entity\Flight;
use App\Entity\Personal;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AddFlightPersonalService
{
    public $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function addPersonal(Flight $flight)
    {
        $faker = Faker\Factory::create();
        $personals = $this->manager->getRepository('App:Personal');
        $companies = $this->manager->getRepository('App:Company')->findAll();

        $company = $companies[rand(0, count($companies) - 1)];

        $pilots = $personals->findBy(['function'=>'Pilot']);
        $copilots = $personals->findBy(['function'=>'Copilot']);
        $stewards = $personals->findBy(['function'=>'Steward']);
        $hostesses = $personals->findBy(['function'=>'Hostess']);

        if(count($pilots) === 0){
            $pilot = new Personal();
            $pilot
                ->setFunction('Pilot')
                ->setName($faker->name)
                ->setCompany($company)
                ->addFlight($flight);
            $this->manager->persist($pilot);
        }
        else {
            $flight->addPersonal($pilots[rand(0, count($pilots) - 1)]);
            $this->manager->persist($flight);
        }

        if(count($copilots) === 0){
            $copilot = new Personal();
            $copilot
                ->setFunction('Copilot')
                ->setName($faker->name)
                ->setCompany($company)
                ->addFlight($flight);
            $this->manager->persist($copilot);
        }
        else {
            $flight->addPersonal($copilots[rand(0, count($copilots) - 1)]);
            $this->manager->persist($flight);
        }

        if(count($stewards) === 0){
            $steward = new Personal();
            $steward
                ->setFunction('Steward')
                ->setName($faker->name)
                ->setCompany($company)
                ->addFlight($flight);
            $this->manager->persist($steward);
        }
        else {
            $flight->addPersonal($stewards[rand(0, count($stewards) - 1)]);
            $this->manager->persist($flight);
        }

        if(count($hostesses) === 0){
            $hostess = new Personal();
            $hostess
                ->setFunction('Hostess')
                ->setName($faker->name)
                ->setCompany($company)
                ->addFlight($flight);
            $this->manager->persist($hostess);
        }
        else {
            $flight->addPersonal($hostesses[rand(0, count($hostesses) - 1)]);
            $this->manager->persist($flight);
        }

        $this->manager->flush();
    }
}
