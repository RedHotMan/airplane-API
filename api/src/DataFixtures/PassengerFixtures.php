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
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PassengerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $passenger = new Passenger();
            $passenger->setFirstname($faker->firstName);
            $passenger->setLastname($faker->lastName);
            $passenger->setBirthdate($faker->dateTime);
            $passenger->setGender($faker->boolean());
            $manager->persist($passenger);
        }

        $manager->flush();
    }
}
