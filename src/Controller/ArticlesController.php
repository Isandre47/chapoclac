<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/articles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="articles_index", methods="GET")
     */
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('admin/article/article.html.twig', [
            'articles' => $articlesRepository->findBy([], ['id' => 'DESC'])]);
    }

    /**
     * @Route("/new", name="articles_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $article = new Articles();
        $article->setDateCreation(new \DateTime('now'));
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $article->getMedias();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_articles_directory'), $fileName);
            $article->setMedias($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('articles_index');
        }

        return $this->render('/admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="articles_show", methods="GET")
     */
    public function show(Articles $article): Response
    {
        return $this->render('/admin/article/article.html.twig', ['articles' => $article]);
    }

    /**
     * @Route("/{id}/edit", name="articles_edit", methods="GET|POST")
     */
    public function edit(Request $request, Articles $article): Response
    {
        $oldMedia = $article->getMedias();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $file = $article->getMedias();
            $data->setMedias($file);
            if ($form['medias']->getData() != null){
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_articles_directory'), $fileName);
                $data->setMedias($fileName);
            }else{
                $article->setMedias($oldMedia);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articles_index', ['id' => $article->getId()]);
        }

        return $this->render('/admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="articles_delete", methods="DELETE")
     * @param Request $request
     * @param Articles $article
     * @return Response
     */
    public function delete(Request $request, Articles $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('articles_index');
    }
}