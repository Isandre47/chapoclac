<?php

namespace App\Controller;

use App\Entity\Spectacles;
use App\Form\SpectaclesType;
use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/spectacles")
 */
class SpectaclesController extends AbstractController
{
    /**
     * @Route("/", name="spectacles_index", methods="GET")
     */
    public function index(SpectaclesRepository $spectaclesRepository): Response
    {
        return $this->render('admin/spectacles/index.html.twig', ['spectacles' => $spectaclesRepository->findAll()]);
    }

    /**
     * @Route("/new", name="spectacles_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $spectacle = new Spectacles();
        $form = $this->createForm(SpectaclesType::class, $spectacle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($form);
            $file = $spectacle->getPoster();
            $fileName = md5(uniqid()).'.'. $file->guessExtension();
            $file->move($this->getParameter('upload_posters_directory'), $fileName);
            $spectacle->setPoster($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($spectacle);
            $em->flush();

            return $this->redirectToRoute('spectacles_index');
        }

        return $this->render('admin/spectacles/new.html.twig', [
            'spectacle' => $spectacle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spectacles_show", methods="GET")
     */
    public function show(Spectacles $spectacle): Response
    {
//        $spectacle =$spectacle->getUsers();
        return $this->render('admin/spectacles/show.html.twig', ['spectacle' => $spectacle]);
    }

    /**
     * @Route("/{id}/edit", name="spectacles_edit", methods="GET|POST")
     */
    public function edit(Request $request, Spectacles $spectacle): Response
    {
        $oldPoster = $spectacle->getPoster();
        $form = $this->createForm(SpectaclesType::class, $spectacle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $file = $spectacle->getPoster();
            $data->setPoster($file);
            if($form['poster']->getData() != null){
                $fileName = md5(uniqid()).'.'. $file->guessExtension();
                $file->move($this->getParameter('upload_posters_directory'), $fileName);
                $data->setPoster($fileName);
            }else{
                $spectacle->setPoster($oldPoster);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            return $this->redirectToRoute('spectacles_index', ['id' => $spectacle->getId()]);
        }

        return $this->render('admin/spectacles/edit.html.twig', [
            'spectacle' => $spectacle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spectacles_delete", methods="DELETE")
     */
    public function delete(Request $request, Spectacles $spectacle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spectacle->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spectacle);
            $em->flush();
        }

        return $this->redirectToRoute('spectacles_index');
    }
}
