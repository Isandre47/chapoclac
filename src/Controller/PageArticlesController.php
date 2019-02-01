<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\ArticlesController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\Routing\Annotation\Route;

class PageArticlesController extends AbstractController
{
    /**
     * @Route("all_articles", name="all_articles")
     */
    public function allArticles(ArticlesRepository$articlesRepository, Request $request)
    {
        $articles = $articlesRepository->findByPage(
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('user/allArticles.html.twig',
            ['articles' => $articles]);
    }
    /**
     * @Route("chapo-clac-articles", name="chapo_clac_articles")
     */
    public function chapoClacArticles(ArticlesRepository $articlesRepository, Request $request)
    {
            $articles =
                $articlesRepository->findByPageChapoActuality(
                $request->query->getInt('page', 1),
                12
            );


        return $this->render('user/chapoClacArticles.html.twig',
            ['articles' => $articles]);
    }
    /**
     * @Route("friends_articles", name="friends_articles")
     */
    public function friendsArticles(ArticlesRepository $articlesRepository, Request $request)
    {
        $articles =
            $articlesRepository->findByPageFriendsActuality(
                $request->query->getInt('page', 1),
                12
            );


        return $this->render('user/friendsArticles.html.twig',
            ['articles' => $articles]);
    }

    /**
     * @Route("/article/{id}", name="show_article")
     */

    public function show(Articles $article, Request $request)
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setDate(new \DateTime('now'));
            if ($this->getUser() !== null) {
                $comment->setAuthor($this->getUser());
            }
            $comment->setArticles($article);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('show_article', ['id' => $article->getId()]);
        }

        return $this->render('user/showArticles.html.twig', [
            'article' => $article,
            'form' => $form->createView()
            ]);
    }
}

