<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Personne;

class PersonneFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {  $faker = Factory::create();
        for ($i=0 ; $i< 30 ; $i++){

            $personne = new Personne();
            $personne->setName($faker->firstName);
            $personne->setAge($faker->numberBetween(18,35));
            $personne->setLastname($faker->lastName);
            $manager->persist($personne);

        }

        $manager->flush();
    }
}
