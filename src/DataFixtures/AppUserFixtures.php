<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppUserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setPassword($this->hasher->hashPassword($user, "Moderator@4321"));
        $user->setRoles(['ROLE_USER','ROLE_MODERATOR']);
        $user->setEmail("moderator@mail.com");
        $user->setName("ModeratorUser");
        $manager->persist($user);

        $user = new User();
        $user->setPassword($this->hasher->hashPassword($user, "Admin@4321"));
        $user->setRoles(['ROLE_USER','ROLE_ADMIN']);
        $user->setEmail("admin@mail.com");
        $user->setName("AdminUser");
        $manager->persist($user);

        $manager->flush();
    }
}
