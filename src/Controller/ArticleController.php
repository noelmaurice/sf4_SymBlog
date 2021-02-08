<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/article", name="article_")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     * @Route("/update/{id}", name="update")
     */
    public function addOrUpdapteArticle(Article $article = null, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        if ($article == null)
        {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (! $article->getId())
            {
                $article->setCreatedAt(new \DateTime());
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_view', array(
                "id" => $article->getId()
            ));
        }

        return $this->render('article/addOrUpdate.html.twig', array(
            "formArticle" => $form->createView(),
            "editMode" => $article->getId() !== null
        ));

    }



    /**
     * @Route("/all", name="all")
     */
    public function getAllArticle(ArticleRepository $repository)
    {
        $articles = $repository->findAll();

        return $this->render('article/view_all.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/{id}", name="view")
     */
    public function getArticle(Article $article, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $comment->setCreatedDate(new \DateTime())
                ->setArticle($article);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('article_view', array(
                "id" => $article->getId()
            ));
        }

        return $this->render('article/view.html.twig', [
            "article" => $article,
            "form" => $form->createView()
        ]);
    }





}
