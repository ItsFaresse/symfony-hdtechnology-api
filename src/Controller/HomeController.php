<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticlesRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticlesRepository $repository)
    {
        $articles = $repository->findLatest();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController', 'articles' => $articles
        ]);
    }

    /**
     * @Route("show", name="show")
     */
    public function detail()
    {
        return $this->render('pages/show.html.twig', [
            'controller_name' => 'HomeController'
        ]);
    }
}
