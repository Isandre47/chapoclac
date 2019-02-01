<?php

namespace App\Controller;

use App\Entity\Presentation;
use App\Form\PresentationType;
use App\Repository\PresentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/presentation")
 */
class PresentationController extends AbstractController
{
    /**
     * @Route("/", name="presentation_index", methods="GET")
     */
    public function index(PresentationRepository $presentationRepository): Response
    {
        return $this->render('admin/presentation/index.html.twig', ['presentation' => $presentationRepository->findOneById(1)]);
    }

    /**
     * @Route("/{id}/edit", name="presentation_edit", methods="GET|POST")
     */
    public function edit(Request $request, Presentation $presentation): Response
    {
        $form = $this->createForm(PresentationType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('presentation_index', ['id' => $presentation->getId()]);
        }

        return $this->render('admin/presentation/edit.html.twig', [
            'presentation' => $presentation,
            'form' => $form->createView(),
        ]);
    }
}
