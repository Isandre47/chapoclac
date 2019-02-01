<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Form\ActivitiesType;
use App\Repository\ActivitiesRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Registration;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @Route("/admin/activities")
 */
class ActivitiesController extends AbstractController
{
    /**
     * @Route("/", name="activities", methods="GET")
     */
    public function index(ActivitiesRepository $activitiesRepository, RegistrationRepository $registrationRepository): Response
    {
        return $this->render('admin/class/cours.html.twig', [
            'activities' => $activitiesRepository->findAll(),
            'registrations' => $registrationRepository->findBy(['validated' => 'oui'])
        ]);
    }

    /**
     * @Route("/new", name="activities_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $activity = new Activities();
        $form = $this->createForm(ActivitiesType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $activity->getPicture();
            $fileName = md5(uniqid()) . '.' .$file->guessExtension();
            $file->move($this->getParameter('upload_activities_directory'), $fileName);
            $activity->setPicture($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();


            return $this->redirectToRoute('activities');
        }

        return $this->render('admin/class/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}", name="activities_show", methods="GET")
//     */
//    public function show(Activities $activity): Response
//    {
//        return $this->render('activities/show.html.twig', ['activity' => $activity]);
//    }

    /**
     * @Route("/{id}/edit", name="activities_edit", methods="GET|POST")
     */
    public function edit(Request $request, Activities $activity): Response
    {
        $oldPicture = $activity->getPicture();
        $form = $this->createForm(ActivitiesType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $file = $activity->getPicture();
            $data->setPicture($file);
            if($form['picture']->getData() != null){
                $fileName = md5(uniqid()) . '.' .$file->guessExtension();
                $file->move($this->getParameter('upload_activities_directory'), $fileName);
                $data->setPicture($fileName);
            }else{
                $activity->setPicture($oldPicture);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activities'  );
        }

        return $this->render('admin/class/edit.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activities_delete", methods="DELETE")
     */
    public function delete(Request $request, Activities $activity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activity->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activity);
            $em->flush();
        }

        return $this->redirectToRoute('activities');
    }

    /**
     * @param Registration $registration
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/reservation/{id}/unregistration", name="admin_un")
     */
    public function unregistrationActivityAdmin( Registration $registration, EntityManagerInterface $em)
    {
        $em->remove($registration);
        $em->flush();

        $this->addFlash('success', "Désinscription pris en compte.");

        return $this->redirectToRoute('activities');
    }
}
