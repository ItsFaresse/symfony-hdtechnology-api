<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Articles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
        $article = new Articles();
        $article->setName($faker->jobTitle);
        $article->setContent($faker->realText($maxNbChars = 200, $indexSize = 2));
        $article->setImage($faker->imageUrl($width = 640, $height = 480));
        $manager->persist($article);
        }
        $manager->flush();
    }
}