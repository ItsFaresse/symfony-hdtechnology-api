<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminArticlesController extends AbstractController
{
    /**
     * @var ArticlesRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ArticlesRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em =$em;
    }

    /**
     * @Route("/admin", name="admin.articles.index")
     * @return Response
     */
    public function  index()
    {
        $articles = $this->repository->findAll();
        return $this->render('admin/articles/index.html.twig', compact('articles'));
    }

    /**
     * @Route("/admin/articles/create", name="admin.articles.new")
     */
    public function new(Request $request)
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash('success', 'Ajouté avec succès !');
            return $this->redirectToRoute('admin.articles.index');
        }
        return $this->render("admin/articles/new.html.twig", [
            'articles' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/{id}", name="admin.articles.edit", methods="GET|POST")
     * @param Articles $articles
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Articles $articles, Request $request)
    {
        $form = $this->createForm(ArticlesType::class, $articles);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succès !');
            return $this->redirectToRoute('admin.articles.index');
        }
        return $this->render("admin/articles/edit.html.twig", [
            'articles' => $articles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/{id}", name="admin.articles.delete", methods="DELETE")
     * @param Articles $articles
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Articles $articles, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $articles->getId(), $request->get('_token'))) {
            $this->getDoctrine()->getEntityManager();
            $this->em->remove($articles);
            $this->em->flush();
            $this->addFlash('success', 'Supprimé avec succès !');
        }
        return $this->redirectToRoute('admin.articles.index');
    }

}
