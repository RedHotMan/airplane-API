<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin')
            ->setEmail('admin@admin.com')
            ->setPassword($this->passwordEncoder->encodePassword($admin, 'admin'));
        $admin->setRoles('ROLE_USER');
        $admin->setRoles('ROLE_ADMIN');
        $manager->persist($admin);
        $manager->flush();
    }
}