<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const USERS = [
        ['email' => 'user@fos.fr'],
        ['email' => 'receiver@fos.fr'],
    ];

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::USERS as $userEmail) {
            $user = new User();
            $user->setEmail($userEmail['email']);

            $password = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
