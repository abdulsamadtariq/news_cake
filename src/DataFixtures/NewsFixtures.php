<?php

namespace App\DataFixtures;

use App\Entity\News;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NewsFixtures extends Fixture
{
    protected $faker;
    public function load(ObjectManager $manager): void
    {
        $this->faker =Factory::create();
        for ($i = 0; $i < 100; ++$i) {
     
            $news = new News();
            $news->setTitle($this->faker->name); 
            $news->setShortDescription($this->faker->text); 
            $news->setPicture("https://highload.today/wp-content/uploads/2022/11/Bezymyannyvyvyyj.jpg.webp"); 
            $news->setCreatedAt(new DateTimeImmutable()); 
            $news->setUpdatedAt(new DateTimeImmutable()); 
            $news->setAddedAt(new DateTimeImmutable()); 
            $manager->persist($news);      
       }

        $manager->flush();
    }
}
