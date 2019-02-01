<?php
namespace App\Controller;

use App\Entity\Users;
use App\Form\RegisterType;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('user');
    }
    /**
     * @Route("/admin/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        if ($request->isMethod('POST')){
            $user = new Users();
            $user->setEmail($request->request->get('email'));
            $user->setLastName($request->request->get('lastName'));
            $user->setFirstName($request->request->get('firstName'));
            $user->setPhoneMobil($request->request->get('phoneMobil'));
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $em =$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('security/register.html.twig');
    }
    /**
     * @Route("/login", name="login_user")
     */
    public function loginUser(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
//        return $this->redirectToRoute('reservation');
        return $this->render('security/loginUser.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * @Route("/register", name="app_register")
     */
    public function registerUser(MailsController $mailsController, Request $request, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user = new Users();
        $user->setCreateDate(new \DateTime('now'));
        $user->setRoles(["ROLE_USER"]);
        $user->setNumberCheck('000');
        $user->setContributions('non');
        $user->setValidate('non');
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $mailsController->sendMailNewUser($user);
            $mailsController->sendMailNewUserToAdmin($user);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/registerUser.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/forgotten_password", name="app_forgotten_password")
     */
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        if($request->isMethod('POST')){
            $email = $request->request->get('email');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(Users::class)->findOneByEmail($email);
            /* @var $user User */

            if ($user === null){
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('homepage');
            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $em->flush();
            } catch (\Exception $e){
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('login_user');
            }

            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGenerator::ABSOLUTE_URL);

            $transport = (new \Swift_SmtpTransport('SSL0.OVH.NET', 465, 'SSL'))
                ->setUsername('contact@chapo-clac.fr')
                ->setPassword('Grosgrasgrandgrindorge69');

            $mailer = new \Swift_Mailer($transport);

            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom(['contact@chapo-clac.fr' => 'Chapo-Clac'])
                ->setTo($user->getEmail())
                ->setBody(

                    'Pour réinitialiser votre mot de passe,  merci de cliquer sur le lien ci-dessous' . "<br/>" . $url, 'text/html'

                );

            $mailer->send($message);

            $this->addFlash('success', "Mail envoyé");

            return $this->redirectToRoute('login_user');
        }

        return $this->render('security/forgotten_password.html.twig');
    }


    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository(Users::class)->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null){
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('login_user');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $em->flush();

            $this->addFlash('success', 'mot de passe mis à jour');
            return $this->redirectToRoute('login_user');
        }
        else{
            return $this->render('security/reset_password.html.twig', ['token'=> $token]);
        }
    }
}
