<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Entity\Spectacles;
use App\Form\GalleryType;
use App\Repository\GalleryRepository;
use App\Repository\SpectaclesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gallery")
 */
class GalleryController extends AbstractController
{
    /**
     * @Route("/{id}", name="gallery_index", methods="GET")
     */
    public function index(Spectacles $spectacle): Response
    {
        return $this->render('/admin/gallery/index.html.twig',
            [
             'spectacle' => $spectacle
            ]);
    }

    /**
     * @Route("/{id}/new", name="gallery_new", methods="GET|POST")
     */
    public function new(Request $request, Spectacles $spectacle): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        $pictures = $form->getData()->getPicture();

        if ($form->isSubmitted() && !empty($spectacle) || !empty($pictures)){

            foreach ($pictures as $file) {
                $gallery = new Gallery();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_gallery_directory'), $fileName);
                $gallery->setPicture($fileName);
                $gallery->setSpectacle($spectacle);
                $em = $this->getDoctrine()->getManager();
                $em->persist($gallery);
            }
            $em->flush();
            return $this->redirectToRoute('gallery_index', ['id' => $spectacle->getId()]);
        }

        return $this->render('/admin/gallery/new.html.twig', [
            'form' => $form->createView(),
            'spectacle' => $spectacle
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gallery_edit", methods="GET|POST")
     */
    public function edit(Request $request, Gallery $gallery): Response
    {
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallery_index', ['id' => $gallery->getId()]);
        }

        return $this->render('/admin/gallery/edit.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete", name="gallery_delete", methods="POST")
     */
    public function delete(Request $request, GalleryRepository $galleryRepository, EntityManagerInterface $em): Response
    {

       $elements = explode(',',$request->get('idElementsToDelete'));

        foreach ($elements as $element){
            $gallery = $galleryRepository->find($element);
            $em->remove($gallery);
        }
            $em->flush();

        return $this->redirectToRoute('gallery_index', ['id' => $request->get('spectacle')]);
    }

}
