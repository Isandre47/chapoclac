<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Entity\Articles;
use App\Entity\Messages;
use App\Entity\Registration;
use App\Form\MessageType;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\ActivitiesRepository;
use App\Repository\CommentsRepository;
use App\Repository\GalleryRepository;
use App\Repository\MessagesRepository;
use App\Repository\PresentationRepository;
use App\Repository\RegistrationRepository;
use App\Repository\SpectaclesRepository;
use App\Repository\UsersRepository;
use App\Repository\YoutubeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="user")
     *
     */
    public function index(
        PresentationRepository $presentationRepository, YoutubeRepository $youtubeRepository, GalleryRepository $galleryRepository,
        SpectaclesRepository $spectaclesRepository, ActivitiesRepository $activitiesRepository, MessagesRepository $messagesRepository,
        UsersRepository $usersRepository, Request $request, RegistrationRepository $registrationRepository,
        MailsController $mailsController): Response
    {
        // Section Souvenir (var for see all spectacles in dropdown menu)
        $allSpectacles = $spectaclesRepository->findAll();

        // TODO: creer une fonction qui permet de recuperer 3 articles par theme
        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->findBy(array(), array('id' => 'DESC'), 3);


        // TODO: envoyer un mail a l'admin après l'envoie d'un message
        $user = $this->getUser();

        $message = new Messages();
        $message->setDateSend(new \DateTime('now'));
        $form = $this->createForm(MessageType::class, $message);

        if ($user !== null) {
            $request->request->set('name', $user->getLastname());
            $request->request->set('email', $user->getEmail());
            $request->request->set('user', $user->getId());

        }

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($user !== null) {
                $message->setName($user->getLastname());
                $message->setEmail($user->getEmail());
                $message->setUser($user, $user->getId());
            }
                $mailsController->sendMailMessage($message->getMessage(), $message->getEmail(), $message->getName());

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();


            // reinit form for redirection
            $message = new Messages();
            $form = $this->createForm(MessageType::class, $message);

            //TODO message flash 'votre message est bien envoyé'
            return $this->redirectToRoute('user', ['_fragment' => 'contact']);

        }

        //Création d'un tableau de user contenant uniquement les roles du bureau
        $bureauRoles = ['Président', 'Président adjoint', 'Secrétaire', 'Secrétaire adjoint', 'Trésorier', 'Trésorier adjoint'];
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();
        $bureau = [];
        foreach ($users as $user){
            $roles = $user->getRoles();
            foreach ($roles as $role){
                if(in_array($role, $bureauRoles)){
                    $bureau[] = $user;
                }
            }
        }

             $userActivities = $this->getActivitiesRegistered();


        return $this->render('user/index.html.twig', [
            'articles'      => $articles,
            'presentations' => $presentationRepository->findAll(),
            'youtubes'      => $youtubeRepository->findAll(),
            'galleries'     => $galleryRepository->findBy([], ['id' => 'DESC'], 3),
            'spectacles'    => $spectaclesRepository->findBy([], ['id' => 'DESC'], 3),
            'activities'    => $activitiesRepository->findAll(),
            'messages'      => $messagesRepository,
            'form'          => $form->createView(),
            'bureau'        => $bureau,
            'oneSpectacle'  => $allSpectacles,
            'userActivities'=> $userActivities,
        ]);
    }

    /**
     * @Route("/reservation/{activity}", name="add_reservation")
     */
    public function registration(MailsController $mailsController, Activities $activity, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $registration = new Registration();
        $registration->setValidated('non');
        $registration->setActivity($activity)
            ->setUser($user);
        $em->persist($registration);
        $em->flush();
        $mailsController->sendMailRegistration($user);
        $this->addFlash('success', "Votre réservation a bien été enregistrée. Vous recevrez une confirmation par mail sous 48h. Merci");

        return $this->redirectToRoute('user', ['_fragment' => 'menu']);
    }

    /**
     * Profil utilisateur
     * @Route("/user/{id}", name="userShow")
     */
    public function show(Users $users): Response
    {
        return $this->render('user/userShow.html.twig', ['user' => $users,]);
    }

    /**
     * Edition du profil utilisateur par l'utilisateur
     * @Route("user/{id}/edit", name="userEdit")
     *
     */
    public function edit(Request $request, Users $users): Response
    {
        $oldPicture = $users->getPicture();
        $form = $this->createForm(UsersType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $file = $users->getPicture();
            $data->setPicture($file);
            if ($form['picture']->getData() != null){
                $picture = $users->getPicture();
                $pictureName = md5(uniqid()).'.'.$picture->guessExtension();
                $picture->move($this->getParameter('upload_users_directory'), $pictureName);
                $users->setPicture($pictureName);
            } else {
                $users->setPicture($oldPicture);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userShow', ['id' => $users->getId()]);
        }

        return $this->render('/user/userEdit.html.twig', [
            'user' => $users,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Registration $registration
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/reservation/{activity}/unregistration", name="user_un")
     */
    public function unregistrationActivity( Registration $registration, EntityManagerInterface $em)
    {
        $em->remove($registration);
        $em->flush();

        $this->addFlash('success', "Désinscription prise en compte.");

        return $this->redirectToRoute('user', ['_fragment' => 'menu']);
    }

    /**
     * Fonction pour recuperer les activites sur lequel le user s'est inscrit
     * @param Users $user
     * @return array
     */
    public function getActivitiesRegistered(){
        $user = $this->getUser();
        if (!empty($user)) {
            $userActivities = [];
            $userRegistrations = $this->getDoctrine()
                ->getRepository(Users::class)
                ->find($user->getId())
                ->getRegistrations();
            foreach ($userRegistrations as $registration) {
                $userActivities[] = $registration->getActivity();
            }
        } else {
            $userActivities = [];
        }
        return $userActivities;
    }

    /**
     * @Route("mentions-legales", name="mentions_legales")
     */
    public function mentionsLegales()
    {
        return $this->render('/user/mentionsLegales.html.twig');
    }
}
