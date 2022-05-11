<?php

namespace App\DataFixtures;

use App\Entity\Possessions;
use App\Entity\Utilisateurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $user = new Utilisateurs();

            $user->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setEmail($faker->email())
                ->setAdresse($faker->address())
                ->setTel($faker->phoneNumber())
                ->setBirthDate($faker->dateTime());


            for ($j = 0; $j < 10; $j++) {
                $possession = new Possessions();

                $possession->setNom($faker->words(3, true))
                    ->setValeur($faker->randomFloat(2, 20, 60))
                    ->setType($faker->word(10, true))
                    ->setUtilisateurs($user);

                $manager->persist($possession);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
