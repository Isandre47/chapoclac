<?php

namespace App\Controller;

use App\Entity\Spectacles;
use App\Repository\GalleryRepository;
use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RemenberSectionController extends AbstractController
{
    /**
     * @Route("/remenber_section", name="remenber_section")
     */
    public function allgallery(SpectaclesRepository $spectaclesRepository, GalleryRepository $galleryRepository)
    {
        $spectacles = $spectaclesRepository->findAll();
        $galeries = $galleryRepository->findAll();

        return $this->render('remenber_section/index.html.twig',
            ['spectacles' => $spectacles,
             'galeries' => $galeries
            ]
        );
    }
    /**
     * @Route("/spectacles/{id}", name="remenber_spectacle")
     */
    public function spectaclesById($id, SpectaclesRepository $spectaclesRepository)
    {
        $spectacles = $spectaclesRepository->findAll();

        $spectaclesById = $this->getDoctrine()
            ->getRepository(Spectacles::class)
            ->find($id);

        return $this->render('remenber_section/spectacles.html.twig',
            ['spectacles' => $spectaclesById,
             'allSpectacles' => $spectacles
            ]);
    }
}
