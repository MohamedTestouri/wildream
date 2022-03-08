<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use App\Form\PostType;
use Doctrine\Persistence\ObjectManager;

class CommentsController extends AbstractController
{
    /**
    * @Route("/comment/add", name="comment_add")
    */
    public function add(Request $request)
    {
        /*$post_id=$request->get('post_id');
        $user =$this->getUser();
        $post=$this->getDoctrine()->getRepository()->find($post_id);
        $comment= new Comment();
        $comment->setBody($request->request->get('_body'));
        $comment->setUser($user);
        $comment->setPost($post);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entitiyManager->flush();

        $post_id=$post->getId();
        
        return $this->redirectToRoute('blog_show', [
            'id'=>$post_id,
           
        ]);*/
    }
}