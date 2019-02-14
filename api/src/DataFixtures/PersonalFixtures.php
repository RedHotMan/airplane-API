<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 14/02/2019
 * Time: 09:45
 */

namespace App\DataFixtures;

use App\Entity\Personal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PersonalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $companies = $manager->getRepository('App:Company')->findAll();
            $personal = new Personal();
            $personal->setName($faker->name);
            $personal->setCompany($companies[$i]);
            $personal->setFunction($faker->sentence);
            $manager->persist($personal);
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
