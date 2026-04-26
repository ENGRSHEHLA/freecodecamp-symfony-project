<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/post', name: 'app_post.')]

final class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();


        return $this->render('post/index.html.twig', [
            // 'controller_name' => 'PostController',

            'posts' => $posts
        ]);
    }

    #[Route('/create', name: 'app_post_create')]
    public function create(Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();

            if ($file) {
                $filename = $fileUploader->uploadFile($file);
                $post->setImage($filename);
            }

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post created successfully');

            return $this->redirectToRoute('app_post.index');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Create New Post',
            'page_subtitle' => 'Add title, category, and optional image for your post.',
            'submit_label' => 'Create Post',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Post $post, Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();

            if ($file) {
                $filename = $fileUploader->uploadFile($file);
                $post->setImage($filename);
            }

            $em->flush();
            $this->addFlash('success', 'Post updated successfully');

            return $this->redirectToRoute('app_post.index');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Update Post',
            'page_subtitle' => 'Edit post details and optionally replace image.',
            'submit_label' => 'Update Post',
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show($id, PostRepository $postRepository): Response
    {
        $post = $postRepository->findPostWithCategory($id);

        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    // #[Route('/show/{id}', name: 'show')]
    // public function show($id, PostRepository $postRepository): Response
    // {
    //     $post = $postRepository->find($id);

    //     if (!$post) {
    //         throw $this->createNotFoundException('Post not found');
    //     }

    //     $previousPost = $postRepository->findOneBy(
    //         ['id' => $id - 1]
    //     );

    //     return $this->render('post/show.html.twig', [
    //         'post' => $post,
    //         'previousPost' => $previousPost,
    //     ]);
    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(?Post $post, EntityManagerInterface $em): Response
    {
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        $em->remove($post);
        $em->flush();
        $this->addFlash('success', 'Post deleted successfully');
        return $this->redirectToRoute('app_post.index');
    }
}
