<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 23/11/18
 * Time: 11:58
 */

namespace App\Controller;

use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment")
     */
    public function index(CommentsRepository $commentsRepository): Response
    {
        $comments = $commentsRepository->findBy([], ['date' => 'DESC']);
        return $this->render('admin/comment/comment.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods="DELETE")
     */
    public function delete(Request $request, Comments $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment');
    }
}