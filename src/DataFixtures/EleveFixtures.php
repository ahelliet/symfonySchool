<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Eleve;
use App\Entity\Classe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EleveFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On instancie Faker avec une locale francaises
        $faker = Faker\Factory::create('fr_FR');

        // On génére un nombre aléatoires de classes (entre min 4 et max 7)
        for ($i = 0; $i < mt_rand(4, 7); $i++) {
            $classe[$i] = new Classe();
            $classe[$i]->setNom($faker->word(2));

            $manager->persist($classe[$i]);

            // on crée un nombre aleatoire d'élèves (entre min 12 et max 30)
            for ($j = 0; $j < mt_rand(12, 30); $j++) {
                $eleve[$j] = new Eleve();
                $eleve[$j]->setClasse($classe[$i]);
                $eleve[$j]->setNom($faker->lastName);
                $eleve[$j]->setPrenom($faker->firstName);
                $eleve[$j]->setDateDeNaissance($faker->dateTimeBetween($startDate = '-20 years', $endDate = '-18 years', $timezone = null));
                $eleve[$j]->setMoyenne(random_int(0, 20));
                $eleve[$j]->setAppreciation($faker->sentence());

                $manager->persist($eleve[$j]);
            }
        }
        $manager->flush();
    }
}
