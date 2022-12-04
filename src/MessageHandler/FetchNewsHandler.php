<?php
namespace App\MessageHandler;

use App\Entity\News;
use App\Message\FetchNewsMessage;
use App\Repository\NewsRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
class FetchNewsHandler extends AbstractController implements MessageHandlerInterface
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
    public function __invoke(FetchNewsMessage $message)
    {
        // invoked when an instance of FetchNewsMessage is dispatched
        sleep(1);
        // all the scrapping code starts here

        $source=$message->getSource();
        $this->entityManager = $this->getDoctrine()->getManager();
        $data = [];
        $content=file_get_contents($source);
        $crawler = new Crawler($content);
        $crawler->filter("div.lenta-item")->each(function(Crawler $c)use(&$data){
            /// this line usually by passes the ads
            if (!$c->filter("span.cat-label")->count()) {
                return;
            }
            /// Find and filter the title
            $title = $c->filter("a h2")->text();
            $news=$this->newsRepository->findOneByTitle($title);
            if(!$news){
                $news = new News();
                $news->setCreatedAt(new DateTimeImmutable());
            }
            $dateTime = $c->filter("span.meta-datetime")->text();
            $dateTime = $this->cleanupDate($dateTime);
            $link = $c->filter("div.lenta-image > img")->attr('data-lazy-src');
            $desc = ($c->filter("p")->last()->text());

            $news->setTitle($title);
            $news->setPicture($link);
            $news->setAddedAt($dateTime);
            $news->setUpdatedAt(new DateTimeImmutable());
            $news->setShortDescription($desc);
            $this->entityManager->persist($news);
            $data[] = $news;
        });
        $this->entityManager->flush();
        print_r("!============done(".count($data).")==========Source:".$source."==========!");

    }
    private function cleanupDate(string $dateTime): \DateTimeImmutable
    {
        $dateTime = str_replace(['(', ')', 'UTC', 'at', '|'], '', $dateTime);
        $dateTime=str_replace("місяць назад","month ago",$dateTime);
        $dateTime=str_replace("місяці назад","months ago",$dateTime);
        $dateTime=str_replace("тиждень назад","week ago",$dateTime);
        $dateTime=str_replace("тижні назад","weeks ago",$dateTime);
        $dateTime=str_replace("дні назад","days ago",$dateTime);
        $dateTime=date('jS F Y H:i.s', strtotime($dateTime));

        return new \DateTimeImmutable($dateTime);
    }
}