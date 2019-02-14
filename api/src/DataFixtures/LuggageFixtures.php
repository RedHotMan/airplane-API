<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 14/02/2019
 * Time: 09:12
 */

namespace App\DataFixtures;

use App\Entity\Luggage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class LuggageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $passengers = $manager->getRepository('App:Passenger')->findAll();
            $luggage = new Luggage();
            $luggage->setHeight($faker->numberBetween(100,210));
            $luggage->setPassenger($passengers[$i]);
            $luggage->setWeight($faker->randomNumber(2));
            $manager->persist($luggage);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            PassengerFixtures::class,
        );
    }
}
