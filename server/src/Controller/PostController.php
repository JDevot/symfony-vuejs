<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use JWT\Authentication\JWT;
use Symfony\Component\Serializer\Serializer;

class PostController extends AbstractController
{
    public function __construct()
    {
    }
    /**
     * @Route("/api/post", name="get_all_post", methods={"GET"})   
     */
    public function getAll(PostRepository $postRepository): JsonResponse
    {
        $posts = $postRepository->findAll();
        $data = [];
        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'body' => $post->getBody(),
                'author' => [
                    'email' => $post->getUser() ? $post->getUser()->getEmail() : null,
                    'id' => $post->getUser() ? $post->getUser()->getId() : null
                ],
                'categorie' => [
                    'label' => $post->getCategorie() ? $post->getCategorie()->getLabel() : null,
                    'id' => $post->getCategorie() ? $post->getCategorie()->getId() : null
                ]
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/post/{id}", name="update_post", methods={"PUT"})
     */
    public function update($id, Request $request, PostRepository $postRepository, CategorieRepository $categorieRepository): JsonResponse
    {
        $post = $postRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
        empty($data['categorie']) ? true : $post->setCategorie($categorieRepository->findOneBy(['label' => $data['categorie']['label']]));
        empty($data['title']) ? true : $post->setTitle($data['title']);
        empty($data['body']) ? true : $post->setBody($data['body']);
        $updatedPost = $postRepository->updatePost($post);
        return new JsonResponse($updatedPost->toArray(), Response::HTTP_OK);
    }
     /**
     * @Route("/api/post/categorie/{id}", name="search_categorie", methods={"GET"})
     */
    public function searchCategorie($id, PostRepository $postRepository): JsonResponse
    {
        $posts = $postRepository->findBy(['categorie' => $id]);
        $data = [];
        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'body' => $post->getBody(),
                'author' => [
                    'email' => $post->getUser() ? $post->getUser()->getEmail() : null,
                    'id' => $post->getUser() ? $post->getUser()->getId() : null
                ],
                'categorie' => [
                    'label' => $post->getCategorie() ? $post->getCategorie()->getLabel() : null,
                    'id' => $post->getCategorie() ? $post->getCategorie()->getId() : null
                ]
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/api/post/author/{id}", name="search_author", methods={"GET"})
     */
    public function searchAuthor($id, PostRepository $postRepository): JsonResponse
    {
        $posts = $postRepository->findBy(['user' => $id]);
        $data = [];
        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'body' => $post->getBody(),
                'author' => [
                    'email' => $post->getUser() ? $post->getUser()->getEmail() : null,
                    'id' => $post->getUser() ? $post->getUser()->getId() : null
                ],
                'categorie' => [
                    'label' => $post->getCategorie() ? $post->getCategorie()->getLabel() : null,
                    'id' => $post->getCategorie() ? $post->getCategorie()->getId() : null
                ]
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/api/post/{id}", name="delete_post", methods={"DELETE"})
     */
    public function delete($id, PostRepository $postRepository): JsonResponse
    {
        $post = $postRepository->findOneBy(['id' => $id]);
        $postRepository->removePost($post);
        return new JsonResponse(['status' => 'Customer deleted'], Response::HTTP_NO_CONTENT);
    }
    /**
     * @Route("/api/post/{id}", name="get_one_post", methods={"GET"})   
     */
    public function show($id, PostRepository $postRepository): JsonResponse
    {
        try {
            $post = $postRepository->findOneBy(['id' => $id]);
            if (!$post){
                throw new NotFoundHttpException('le post avec l id'.$id .'n existe pas');
            }
            $data = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'body' => $post->getBody(),
                'author' => [
                    'email' => $post->getUser() ? $post->getUser()->getEmail() : null,
                    'id' => $post->getUser() ? $post->getUser()->getId() : null
                ],
                'categorie' => [
                    'label' => $post->getCategorie() ? $post->getCategorie()->getLabel() : null,
                    'id' => $post->getCategorie() ? $post->getCategorie()->getId() : null
                 ]
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        } catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/post", name="post", methods={"POST"})
     */
    public function add(Request $request, PostRepository $postRepository, CategorieRepository $categorieRepository): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (empty($data['title']) || empty($data['body'] || empty($data['categorie']))) {
                throw new NotFoundHttpException('Expecting mandatory parameters');
            }
            $title = $data['title'];
            $body = $data['body'];
            $user = $this->getUser();
           $categorie = $categorieRepository->findOneBy(['label' => $data['categorie']]);

            $postRepository->savePost($title, $body, $user,$categorie);
            return new JsonResponse(['status' => 'Post Created'], Response::HTTP_CREATED);
        } catch (Exception $err) {
            
            return new JsonResponse($err, Response::HTTP_FORBIDDEN);
        }
    }
}
