<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NewsListController extends AbstractController
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
    /**
     * @Route("/news/list", name="app_news_list")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $newsQueryBuilder = $this->newsRepository->getPaginatedData();
        $pagination = $paginator->paginate(
            $newsQueryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('news_list/index.html.twig', [
            'controller_name' => 'NewsListController',
            'pagination' => $pagination,
        ]);
    }
    /**
     * @Route("/news/{id}", name="app_news_delete", methods={"POST"})
     */
    public function delete($id): RedirectResponse
    {
        $news = $this->newsRepository->findOneBy(['id' => $id]);
        if($news){
            $this->newsRepository->remove($news);
        }
        $this->addFlash('success', 'News article deleted successfully!');
        return $this->redirectToRoute('app_news_list');
    }
}
