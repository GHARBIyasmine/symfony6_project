<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Profile extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
        for ($i=0 ; $i < 60 ; $i++) {
            $profile = new \App\Entity\Profile();
            $profile->setName($faker->name);
            $profile->setLastname($faker->lastName);
            $profile->setAge($faker->numberBetween(18, 40));
            $profile->setEmail($faker->email);
            $profile->setPassword('1234');
            $manager->persist($profile);
        }
        $manager->flush();
    }
}
