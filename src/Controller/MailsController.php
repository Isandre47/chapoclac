<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Entity\Presentation;
use App\Entity\Users;
use App\Form\PresentationType;
use App\Repository\ActivitiesRepository;
use App\Repository\ArticlesRepository;
use App\Repository\PresentationRepository;
use App\Repository\RegistrationRepository;
use App\Repository\SpectaclesRepository;
use App\Repository\UsersRepository;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MailsController extends AbstractController
{
    /**
     * @Route("/admin/sendMails/send", name="send_mails")
     */
    public function sendMails(SpectaclesRepository $spectaclesRepository, UsersRepository $usersRepository, ActivitiesRepository $activitiesRepository): Response
    {
        $spectacles = $spectaclesRepository->findAll();
        $activities = $activitiesRepository->findAll();

        return $this->render('admin/sendMails/form.html.twig',
            [
                'spectacles' => $spectacles,
                'activities' => $activities
            ]);
    }
    /**
     * @Route("/admin/confirm", name="confirm_mail")
     */
    public function confirmMail(): Response
    {
        return $this->render('admin/sendMails/confirmNewsLetter.html.twig');
    }
    /**
     * @Route("/admin/deniedMail", name="deniedmail")
     */
    public function deniedMail(): Response
    {
        return $this->render('admin/sendMails/deniedNewsLetter.html.twig');
    }
    /**
     * @Route("/admin/sendMail", name="mail")
     *
     */
    public function mail(\Swift_Mailer $mailer, UsersRepository $usersRepository,RegistrationRepository $registrationRepository, EntityManagerInterface $em)
    {
        $allMail = $usersRepository->AllMails();
        $oui = 'oui';
        $mailNewsletter = $usersRepository->mailNewsletter($oui);

        $transport = (new \Swift_SmtpTransport('SSL0.OVH.NET', 465, 'SSL'))
            ->setUsername('contact@chapo-clac.fr')
            ->setPassword('Grosgrasgrandgrindorge69')
        ;
        if (!empty($_POST['message'] AND $_POST ['subject'])){
            // Send mail to All Members
            $mailer = new \Swift_Mailer($transport);
            if ($_POST['groupe'] == 'Tous les membres') {
                $content = $_POST['message'];
                $subject = $_POST['subject'];
                foreach ($allMail as $mail) {
                    $message = (new \Swift_Message($_POST['subject']))
                        ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
                        ->setTo(['' . implode($mail) .'' => 'Chapo-Clac'])
                        ->setCharset('UTF-8')
                        ->setContentType('text/html')
                        ->setBody(

                            $this->renderView('user/templateMail.html.twig',
                                ['content' => $content,
                                    'subject' => $subject
                                ])

                        );
                    $mailer->send($message);
                }
            }
            // Send mail to Newsletter subscripted
            elseif ($_POST['groupe'] == 'Aux abonnés newsletter'){
                $content = $_POST['message'];
                $subject = $_POST['subject'];
                foreach ($mailNewsletter as $mail) {

                    $message = (new \Swift_Message($_POST['subject']))
                        ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
                        ->setTo(['' . implode($mail) .'' => 'Chapo-Clac'])
                        ->setCharset('UTF-8')
                        ->setContentType('text/html')
                        ->setBody(

                       $this->renderView('user/templateMail.html.twig',
                           ['content' => $content,
                            'subject' => $subject
                           ])


                        );
                    $mailer->send($message);
                }
            }
            // Send mail to cours
            else {
                $post = $_POST['groupe'];
                $mailGroup = $registrationRepository->mailGroup($post);
                $content = $_POST['message'];
                $subject = $_POST['subject'];
                foreach ($mailGroup as $mail) {
                    $message = (new \Swift_Message($_POST['subject']))
                        ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
                        ->setTo(['' . implode($mail) .'' => 'Chapo-Clac'])
                        ->setCharset('UTF-8')
                        ->setContentType('text/html')
                        ->setBody(
                            $this->renderView('user/templateMail.html.twig',
                                ['content' => $content,
                                    'subject' => $subject
                                ])
                        );
                    $mailer->send($message);
                }
            }

        }
        return $this->redirectToRoute('confirm_mail');

    }
    public  function sendMailNewUser(Users $users){
        $name = $users->getFirstName();
        $userMail = $users->getEmail();
        $transport = (new \Swift_SmtpTransport('SSL0.OVH.NET', 465, 'SSL'))
            ->setUsername('contact@chapo-clac.fr')
            ->setPassword('Grosgrasgrandgrindorge69');
        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Bienvenue sur Chapo-Clac'))
            ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
            ->setTo(['' . $userMail . '' => 'Chapo-Clac'])
            ->setCharset('UTF-8')
            ->setContentType('text/html')
            ->setBody(

                $this->renderView('user/templateMailConfirmationRegistration.html.twig',
                    ['content' => "Bonjour $name vous êtes bien enregistré sur chapo-clac.fr !",
                        'subject' => 'Confirmation d\'inscription'
                    ])

            );
        $mailer->send($message);
    }

    public  function sendMailNewUserToAdmin(Users $users){
        $firstname = $users->getFirstName();
        $lastName = $users->getLastName();
        $userMail = $users->getEmail();
        $transport = (new \Swift_SmtpTransport('SSL0.OVH.NET', 465, 'SSL'))
            ->setUsername('contact@chapo-clac.fr')
            ->setPassword('Grosgrasgrandgrindorge69');
        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Bienvenue sur Chapo-Clac'))
            ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
            ->setTo(['burochapoclac@free.fr' =>'Chapo-Clac'])
            ->setCharset('UTF-8')
            ->setContentType('text/html')
            ->setBody(

                $this->renderView('user/templateMailConfirmationRegistration.html.twig',
                    ['content' => $firstname . ' ' . $lastName . ' ' . "vient de s'enregistrer sur chapo-clac.fr !",
                        'subject' => 'Confirmation d\'inscription'
                    ])

            );
        $mailer->send($message);
    }

    public function sendMailRegistration(Users $users){
        $firstname = $users->getFirstName();
        $lastName = $users->getLastName();
        $transport = (new \Swift_SmtpTransport('SSL0.OVH.NET', 465, 'SSL'))
            ->setUsername('contact@chapo-clac.fr')
            ->setPassword('Grosgrasgrandgrindorge69');

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Vous avez une nouvelle demande d\'inscription !'))
            ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
            ->setTo(['burochapoclac@free.fr' =>'Chapo-Clac'])
            ->setCharset('UTF-8')
            ->setContentType('text/html')
            ->setBody(

                $this->renderView('user/templateMailNewUser.html.twig',
                      ['content' => "Vous avez une nouvelle demande d\'inscription de . ' ' . $firstname . ' ' . $lastName . ' ' . '!' . <br/> . http://chapo-clac.fr/login" ,
                        'subject' => 'Vous avez une nouvelle demande d\'inscription !'
                    ])
            );
        $mailer->send($message);
    }
    public function sendMailConfirmationRegister(Users $users){
        $mail = $users->getEmail();
        $transport = (new \Swift_SmtpTransport('SSL0.OVH.NET', 465, 'SSL'))
            ->setUsername('contact@chapo-clac.fr')
            ->setPassword('Grosgrasgrandgrindorge69');

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Votre inscription sur Chapo-Clac a été acceptée !'))
            ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
            ->setTo([$mail => 'Chapo-Clac'])
            ->setCharset('UTF-8')
            ->setContentType('text/html')
            ->setBody(

                $this->renderView('user/templateMailConfirmationCours.html.twig',
                    ['content' => 'Votre inscription sur chapo-clac est confirmée !',
                        'subject' => 'Votre inscription sur chapo-clac est confirmée !'
                    ])

            );
        $mailer->send($message);
    }
    public function sendMailMessage($bodyMessage, $email, $name)
    {
        $transport = (new \Swift_SmtpTransport('SSL0.OVH.NET', 465, 'SSL'))
            ->setUsername('contact@chapo-clac.fr')
            ->setPassword('Grosgrasgrandgrindorge69');

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Vous avez un nouveau message'))
            ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
            ->setTo(['burochapoclac@free.fr' =>'Chapo-Clac'])
            ->setCharset('UTF-8')
            ->setContentType('text/html')
            ->setBody(

                $this->renderView('user/templateMailContact.html.twig',
                    ['content' => 'Message : ' . $bodyMessage ,
                        'subject' => 'Vous avez un nouveau message de ',
                        'identity' => $name . '.' .' ' . "Vous pouvez lui répondre à l'adresse : ",
                        'email' => $email
                    ])

                );
        $mailer->send($message);
    }
}
