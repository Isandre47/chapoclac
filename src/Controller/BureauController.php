<?php
namespace App\Controller;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class BureauController extends AbstractController
{
    /**
     * @Route("/admin/bureau", name="bureau")
     */
    public function index()
    {
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
        return $this->render('admin/office/bureau.html.twig', [
            'bureau' => $bureau,
        ]);
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/bureau/edit", name="bureau/edit")
     */
    public function formBureau()
    {
        return $this->render('admin/office/_form.html.twig', [
            'controller_name' => 'BureauController',
        ]);
    }
}