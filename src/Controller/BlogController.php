<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use App\Form\PostType;

class BlogController extends AbstractController
{
    /**
    * @Route("/", name="blog")
    */
    public function index(Request $request,PostRepository $pubrepo): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)
                                ->findBy([],['time'=>'DESC']);
        $latests = $pubrepo->getLatest();
        $post = new Post();
        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = new File($post->getImage());
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$fileName);
            $post->setImage($fileName);
            $post->setSlug("thisslug");
            $post->setTime( new \DateTime('now'));
            $em= $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('blog');
        }
        return $this->render('blog/index.html.twig', [
           'formpost'=>$form->createView(),
           'posts'=> $posts,
           'latests'=> $latests
        ]);
    }
      /**
     * @Route("/blog/{id}", name="blogshow")
     */
    public function show($id,PostRepository $pubrepo )
    {
        $post = $this->getDoctrine()->getRepository(Post::class)
                                ->findOneBy(['id' => $id]);

        $latests = $pubrepo->getLatest();

        return $this->render('blog/show.html.twig', [
           'post'=> $post,
           'latests'=> $latests
        ]);
    }
     /**
     * @Route("/posts/{username}", name="user_posts")
     */
    public function renderUserPosts(User $user,PostRepository $pubrepo )
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)
                                ->findBy(['user' => $user],['time'=>'DESC']);

        

        return $this->render('blog/user_posts.html.twig', [
           'posts'=> $posts,
           'user'=>$user
        ]);
    }
}
