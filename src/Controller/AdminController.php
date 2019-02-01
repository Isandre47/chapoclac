<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Entity\Users;
use App\Repository\ArticlesRepository;
use App\Repository\MessagesRepository;
use App\Repository\RegistrationRepository;
use App\Repository\SpectaclesRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UsersRepository $usersRepository, ArticlesRepository $articlesRepository,
                          SpectaclesRepository $spectaclesRepository, MessagesRepository $messagesRepository,
                          RegistrationRepository $registrationRepository) :Response
    {

        $usersValidate = $registrationRepository->findBy(['validated' => 'non']);


        return $this->render('admin/dashboard.html.twig', [
            'allUsers' => $usersRepository->findAll(),
            'allArticles' => $articlesRepository->findAll(),
            'users' => $usersRepository->findBy([], ['createDate' => 'DESC'], 10),
            'articles' => $articlesRepository->findby([], ['dateCreation' =>'DESC'], 10),
            'spectacles' => $spectaclesRepository->findAll(),
            'messages' => $messagesRepository->findBy([], ['date_send' => 'DESC'], 10),
            'validates' => $usersValidate

        ]);
    }

    /**
     * @param Request $request
     * @Route("/admin/message/content", name="message_content")
     */
    public function getMessageContent(Request $request, MessagesRepository $messagesRepository)
    {
        //recuperation de l'id message
        $id = $request->request->get('id');
        //recuperation du message
        $message = $messagesRepository->find($id);

        $template = $this->renderView('admin/message.html.twig', [
            'message' => $message
        ]);

        return $this->json(['template' => $template]);
    }
}
