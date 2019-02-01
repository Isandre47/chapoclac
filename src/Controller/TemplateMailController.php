<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TemplateMailController extends AbstractController
{
    /**
     * @Route("/templateMail", name="templateMail")
     */
    public function index()
    {
        return $this->render('user/templateMail.html.twig');
    }
}
