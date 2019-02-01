<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Form\RegistrationType;
use App\Repository\RegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/registration")
 */
class RegistrationController extends AbstractController
{

    /**
     * @Route("/new", name="registration_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $registration = new Registration();
        $form = $this->createForm(RegistrationType::class, $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $registration->getUser();
            $activity = $registration->getActivity();
            $registrations = $entityManager->getRepository(Registration::class)->findBy([
                'user' => $user,
                'activity' => $activity
            ]);
            if(empty($registrations)){
                $entityManager->persist($registration);
                $entityManager->flush();

                return $this->redirectToRoute('activities');
            }else{
                $this->addFlash('danger', 'Cet utilisateur est déjà inscrit à ce cours');
                return $this->redirectToRoute('registration_new');
            }
        }

        return $this->render('admin/registration/new.html.twig', [
            'registration' => $registration,
            'form' => $form->createView(),
        ]);
    }
}
