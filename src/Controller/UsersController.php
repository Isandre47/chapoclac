<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Entity\Registration;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\ActivitiesRepository;
use App\Repository\ArticlesRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/users")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="users_index", methods="GET")
     */
    public function index(UsersRepository $usersRepository, RegistrationRepository $registrationRepository): Response
    {
        $usersValidate = $usersRepository->userRegister('non');
        $validateActivity = $registrationRepository->findBy(['validated' => 'non']);

        return $this->render('/admin/users/index.html.twig', [
            'users' => $usersRepository->findBy([], ['lastName' => 'ASC']),
            'usersValidate' => $usersValidate,
            'validate' => $validateActivity
        ]);
    }

    /**
     * @Route("/new", name="users_new", methods="GET|POST")
     */
    public function new(Request $request, MailsController $mailsController, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Users();
        $user->setCreateDate(new \DateTime('now'));
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPicture() !== null && $user->getPictureFun() !== null){
                $picture = $user->getPicture();
                $pictureName = md5(uniqid()).'.'.$picture->guessExtension();
                $picture->move($this->getParameter('upload_users_directory'), $pictureName);
                $user->setPicture($pictureName);

                $pictureFun = $user->getPictureFun();
                $pictureFunName = md5(uniqid()).'.'.$pictureFun->guessExtension();
                $pictureFun->move($this->getParameter('upload_users_directory'), $pictureFunName);
                $user->setPictureFun($pictureFunName);
            }
            $password = $passwordEncoder->encodePassword($user, 'bienvenue');
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            $mailsController->sendMailNewUser($user);

            return $this->redirectToRoute('users_index');
        }

        return $this->render('/admin/users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="users_show", methods="GET")
     */
    public function show(Users $user): Response
    {
        return $this->render('/admin/users/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="users_edit", methods="GET|POST")
     */
    public function edit(Request $request, Users $user): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPicture() !== null ) {
                $picture = $user->getPicture();
                $pictureName = md5(uniqid()) . '.' . $picture->guessExtension();
                $picture->move($this->getParameter('upload_users_directory'), $pictureName);
                $user->setPicture($pictureName);
            }

            if ($user->getPictureFun() !== null) {
                $pictureFun = $user->getPictureFun();
                $pictureFunName = md5(uniqid()) . '.' . $pictureFun->guessExtension();
                $pictureFun->move($this->getParameter('upload_users_directory'), $pictureFunName);
                $user->setPictureFun($pictureFunName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_index', ['id' => $user->getId()]);
        }

        return $this->render('/admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Reatribut articles author to president
     * @Route("/{id}", name="users_delete", methods="DELETE")
     */
    public function delete(Request $request, Users $user, ArticlesRepository $articlesRepository): Response
    {
        if($this->getUser() == $user){
            $this->addFlash('danger', "Vous ne pouvez pas vous supprimer vous-même !!!");

            return $this->redirectToRoute('users_index');
        }
        //rechercher l'user avec le role president
        $bureauRoles = ['Président'];
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();
        $president = [];
        foreach ($users as $key) {
            $roles = $key->getRoles();
            foreach ($roles as $role) {
                if (in_array($role, $bureauRoles)) {
                    $president[] = $key;
                }
            }
        }

        //recuperer tous les articles de l'user
        $userArticles = $user->getArticles();
        foreach ($userArticles as $userArticle) {
            $userArticle->setAuthor($president[0]);
        }
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('users_index');
    }

    /**
     * @Route("/password/reset/{id}", name="users_password_reset")
     */
    public function changePassword($user = null, UserPasswordEncoderInterface $encoder)
    {
        // TODO : creer un formulaire avec les champs password
        $form = $this->createFormBuilder()
            ->add('plainPassword', TextType::class)
            ->add('repeatPassword', TextType::class)
            ->getForm();
        // TODO : reencoder le password
        if ($form->isSubmitted()){
            // recupere le champ du formulaire avec mot de passe en claire
            $plainPassword = $user->getPlainPassword();
            // Encrypt password
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
            // send to database
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        // TODO: return un formulaire vide ou prerempli
        return $this->render('users/changePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Registration $registration
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{user}/validate", name="user_validate")
     */
    public function validateUser(MailsController $mailsController, Users $user, EntityManagerInterface $em)
    {
        $user->setValidate('oui');

        $em->flush();

        $this->addFlash('success', "Validation effectuée !!!");


        return $this->redirectToRoute('users_index');
    }


    /**
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/activity/{registration}/notvalidate", name="activity_notValidate")
     */
    public function notValidateActivity(Registration $registration, EntityManagerInterface $em)
    {
        $em->remove($registration);
        $em->flush();

//        $user->getEmail();
        $this->addFlash('success', "Validation refusée...");

        //TODO: envoyer email pour informer du refus
        return $this->redirectToRoute('users_index');

    }

    /**
     * @param $id
     * @param UsersRepository $usersRepository
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/activity/{registration}/validate", name="activity_validate")
     */
    public function validateActivity(MailsController $mailsController, Registration $registration, EntityManagerInterface $em)
    {
        $registration->setValidated('oui');
        $em->flush();
        $user = $registration->getUser();
        $mailsController->sendMailConfirmationRegister($user);
        $this->addFlash('success', "Inscription au cours confirmée...");

        //TODO: envoyer email pour informer du refus
        return $this->redirectToRoute('users_index');

    }
}
