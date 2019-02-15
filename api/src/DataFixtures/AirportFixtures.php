<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 14/02/2019
 * Time: 10:05
 */

namespace App\DataFixtures;

use App\Entity\Airport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AirportFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        $cities = $manager->getRepository('App:City')->findAll();

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $airport = new Airport();
            $airportName = $faker->city.' Airport';
            $airport->setName($airportName);
            $airport->setCity($cities[$i]);
            $manager->persist($airport);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CityFixtures::class,
        );
    }
}
