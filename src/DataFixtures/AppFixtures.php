<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use function Symfony\Component\Clock\now;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User()
            ->setEmail('support@yourcaryourway.com')
            ->setFirstname('John')
            ->setLastname('Doe')
            ->setRoles(['ROLE_ADMIN', 'ROLE_SUPPORT'])
            ->setIsVerified(true)
            ->setLastActivity(now())
        ;
        $user
            ->setPassword($this->passwordHasher->hashPassword($user, 'admin1234'));
        $manager->persist($user);

        $manager->flush();
    }
}
