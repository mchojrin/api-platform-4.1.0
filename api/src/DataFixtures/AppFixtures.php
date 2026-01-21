<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Client;
use App\Entity\SubscriptionLevel;
use App\Entity\User;
use App\Entity\Writer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $essential = $this->addSubscriptionLevel('Essential', 28, 120);
        $manager->persist($essential);
        $advanced = $this->addSubscriptionLevel('Advanced', 21, 60);
        $manager->persist($advanced);
        $premium = $this->addSubscriptionLevel('Premium', 0, 28);
        $manager->persist($premium);

        $manager->flush();
        
        $manager->persist($this->addClient('essential@test.com', 'password789', $essential));
        $manager->persist($this->addClient('advanced@test.com', 'password789', $advanced));
        $manager->persist($this->addClient('premium@test.com', 'password789', $premium));
        $manager->persist($this->addAdmin('admin@test.com', 'password123'));
        $manager->persist($this->addWriter('writer@test.com', 'password456'));

        $manager->flush();
    }

    private function addSubscriptionLevel(string $name, int $minWaitDays, int $maxWaitDays): SubscriptionLevel
    {
        return new SubscriptionLevel($name, $minWaitDays, $maxWaitDays);
    }

    private function addClient(string $email, string $password, SubscriptionLevel $subscriptionLevel): Client
    {
        $user = new Client();
        $user->setEmail($email);

        $password = $this->hasher->hashPassword($user, $password);
        $user->setPassword($password);

        $user->setSubscriptionLevel($subscriptionLevel);

        return $user;
    }

    private function addWriter(string $email, string $password): Writer
    {
        $user = new Writer();
        $user->setEmail($email);

        $password = $this->hasher->hashPassword($user, $password);
        $user->setPassword($password);

        return $user;
    }

    
    private function addAdmin(string $email, string $password): Admin
    {
        $user = new Admin();
        $user->setEmail($email);

        $password = $this->hasher->hashPassword($user, $password);
        $user->setPassword($password);

        return $user;
    }
}
