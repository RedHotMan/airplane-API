<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 14/02/2019
 * Time: 10:40
 */

namespace App\DataFixtures;

use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PlaneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        $companies = $manager->getRepository('App:Company')->findAll();

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $plane = new Plane();
            $plane->setNumber($faker->randomNumber(4));
            $plane->setCompany($companies[$i]);
            $plane->setModel($faker->sentence(2));
            $plane->setSeatNumber($faker->numberBetween(1, 100));
            $manager->persist($plane);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CompanyFixtures::class,
        );
    }
}
