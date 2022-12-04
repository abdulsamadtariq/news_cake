<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Repository\NewsRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NewsFixtures extends Fixture
{
    protected $faker;
    private $newsRepository;
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
    public function load(ObjectManager $manager): void
    {
        $this->faker =Factory::create();
        for ($i = 0; $i < 2; ++$i) {
            $title=$this->faker->name;
            $news=$this->newsRepository->findOneByTitle($title);
            if(!$news){
                $news = new News();
                $news->setCreatedAt(new DateTimeImmutable()); 
            }
            $news->setTitle($this->faker->name); 
            $news->setShortDescription($this->faker->text); 
            $news->setPicture("https://highload.today/wp-content/uploads/2022/11/Bezymyannyvyvyyj.jpg.webp"); 
            $news->setUpdatedAt(new DateTimeImmutable()); 
            $news->setAddedAt(new DateTimeImmutable()); 
            $manager->persist($news);      
       }

        $manager->flush();
    }
}
