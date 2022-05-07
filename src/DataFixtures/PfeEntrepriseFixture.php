<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\Pfe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class PfeEntrepriseFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create();

       for ($i =0 ; $i<30; $i++){
           $pfe = new Pfe();
           $ent = new Entreprise();
           $ent->setName($faker->company);
           $pfe->setTitle('title'.$i);
           $pfe->setStudent($faker->name.' '.$faker->lastName);
           $pfe->setEntreprise($ent);
           $manager->persist($ent);
           $manager->persist($pfe);

       }

        $manager->flush();
    }
}
