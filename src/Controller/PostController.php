<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\Post1Type;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Include paginator interface

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/admin", name="post_index_back", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function showAll(Request $request, PostRepository $postRepository): Response
    {
        return $this->render('post/indexFront.html.twig', [
            'posts' => $postRepository->findBy([], ['time'=>'DESC']),
        ]);
    }
    /**
     * @Route("/orderTitle", name="post_index_orderTitle", methods={"GET"})
     */
    public function showTitleOrder(Request $request, PostRepository $postRepository): Response
    {
        return $this->render('post/indexFront.html.twig', [
            'posts' => $postRepository->findBy([], ['title'=>'DESC']),
        ]);
    }
    /**
     * @Route("/orderBody", name="post_index_orderBody", methods={"GET"})
     */
    public function showBodyOrder(Request $request, PostRepository $postRepository): Response
    {
        return $this->render('post/indexFront.html.twig', [
            'posts' => $postRepository->findBy([], ['body'=>'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(Post1Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = new File($post->getImage());
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$fileName);
            $post->setImage($this->getParameter('upload_directory').'\\'.$fileName);
            $post->setSlug("thisslug");
            $post->setType("image");
            $post->setLikes(0);
            $post->setTime( new \DateTime('now'));
            $post->setUserid(20);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post, CommentRepository $commentRepository, $id): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'comments' => $commentRepository->findBy(array('post_id' => $id), ['created'=>'DESC']),
        ]);
    }/**
 * @Route("/{id}", name="post_show_front", methods={"GET"})
 */
    public function showFront(Post $post, CommentRepository $commentRepository, $id): Response
    {
        return $this->render('post/showFront.html.twig', [
            'post' => $post,
            'comments' => $commentRepository->findBy(array('post_id' => $id), ['created'=>'DESC']),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(Post1Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
