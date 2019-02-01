<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use App\Repository\YoutubeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/youtube")
 */
class YoutubeController extends AbstractController
{
    /**
     * @Route("/", name="youtube_index", methods="GET")
     */
    public function index(YoutubeRepository $youtubeRepository): Response
    {
        return $this->render('/admin/youtube/index.html.twig', ['youtubes' => $youtubeRepository->findAll()]);
    }

    /**
     * @Route("/new", name="youtube_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $youtube = new Youtube();
        $form = $this->createForm(YoutubeType::class, $youtube);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('picture')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_youtube_directory'), $fileName);
            $youtube->setPicture();

            $em = $this->getDoctrine()->getManager();
            $em->persist($youtube);
            $em->flush();

            return $this->redirectToRoute('youtube_index');
        }

        return $this->render('/admin/youtube/new.html.twig', [
            'youtube' => $youtube,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="youtube_show", methods="GET")
     */
    public function show(Youtube $youtube): Response
    {
        return $this->render('/admin/youtube/show.html.twig', ['youtube' => $youtube]);
    }

    /**
     * @Route("/{id}/edit", name="youtube_edit", methods="GET|POST")
     */
    public function edit(Request $request, Youtube $youtube): Response
    {
        $form = $this->createForm(YoutubeType::class, $youtube);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $youtube->getPicture();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_youtube_directory'), $fileName);
            $youtube->setPicture($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('youtube_index', ['id' => $youtube->getId()]);
        }

        return $this->render('/admin/youtube/edit.html.twig', [
            'youtube' => $youtube,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="youtube_delete", methods="DELETE")
     */
    public function delete(Request $request, Youtube $youtube): Response
    {
        if ($this->isCsrfTokenValid('delete'.$youtube->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($youtube);
            $em->flush();
        }

        return $this->redirectToRoute('youtube_index');
    }
}
