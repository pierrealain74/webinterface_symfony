<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Validator\Constraints\Length;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    
    public function load(ObjectManager $manager): void
    {

        $arrayIngredient = [];
        for ($i = 0; $i <= 25; $i++) {

            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setPrice(mt_rand(0, 50));

            $arrayIngredient[] = $ingredient;
            

            $manager->persist($ingredient);//permet de synchoniser avec ma db avant le flush}


        }


        for ($j = 0; $j < 12; $j++)
        {
            $recipe = new Recipe();

            $recipe->setName($this->faker->word())
            ->setDuration(mt_rand(0, 1) == 1 ? mt_rand(60, 1440) : null)
            ->setDifficulty(mt_rand(0, 1) == 1 ? mt_rand(1, 5) : null)
            ->setDescription($this->faker->realText(rand(10, 400)))
            ->setPrice(mt_rand(0, 1) == 1 ? mt_rand(1, 1000) : null)
            ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false);

            for($k=0; $k < mt_rand(3, 12); $k++)
            {
                /* $recipe_ingredient = new recipe_ingredient(); */
                $recipe->addIngredient($arrayIngredient[mt_rand(0, count($arrayIngredient) - 1)]);
            }

            $manager->persist($recipe);

        }
 
        

        //dd($arrayIngredient);
        $manager->flush();
        //dd($this->faker->realText(rand(10, 1420)));


    }
}