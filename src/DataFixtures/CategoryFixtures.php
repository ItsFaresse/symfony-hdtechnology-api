<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
        $category = new Category();
        $category->setName($faker->company);
        $manager->persist($category);
        }
        $manager->flush();
    }
}
