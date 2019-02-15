<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 14/02/2019
 * Time: 09:14
 */

namespace App\DataFixtures;

use App\Entity\Passenger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PassengerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        $flights = $manager->getRepository('App:Flight')->findAll();

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $passenger = new Passenger();
            $passenger->setFirstname($faker->firstName);
            $passenger->setLastname($faker->lastName);
            $passenger->setBirthdate($faker->dateTimeBetween('-90 years','-10 years'));
            $passenger->setGender($faker->boolean());
            $passenger->addFlight($flights[rand(0, count($flights) - 1)]);
            $manager->persist($passenger);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            FlightFixtures::class
        );
    }
}
