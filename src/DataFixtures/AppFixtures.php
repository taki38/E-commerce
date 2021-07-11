<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder ;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // ADMIN
         $admin = new User();
         $admin->setFirstname('Takieddine')
              ->setLastname('SEHAILIA')
              ->setRoles(['ROLE_ADMIN'])
              ->setEmail('admin@email.fr')
              ->setPassword($this->passwordEncoder->encodePassword($admin, '123456789'));

        $manager->persist($admin);

        //USER
        $user = new User();
        $user->setFirstname('Takieddine')
            ->setLastname('SEHAILIA')
            ->setEmail('user@email.fr')
            ->setPassword($this->passwordEncoder->encodePassword($user, '123456789'));

        $manager->persist($user);

        $manager->flush();
    }
}
