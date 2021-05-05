<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
class PostController
{
    private $postRepository;

    public function __construct(){
    }
    /**
     * @Route("/api/post", name="get_all_post", methods={"GET"})   
     */
    public function getAll(PostRepository $postRepository): JsonResponse {
        $posts = $postRepository->findAll();
        $data = [];
        foreach ($posts as $post){
            $data[] = [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'body' => $post->getBody(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/post/{id}", name="update_post", methods={"PUT"})
     */
    public function update($id, Request $request,PostRepository $postRepository): JsonResponse {
        $post = $postRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
     
        empty($data['title']) ? true : $post->setTitle($data['title']);
        empty($data['body']) ? true : $post->setBody($data['body']);
        $updatedPost = $postRepository->updatePost($post);
        return new JsonResponse($updatedPost->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/api/post/{id}", name="delete_post", methods={"DELETE"})
     */
    public function delete($id,PostRepository $postRepository): JsonResponse{
        $post = $postRepository->findOneBy(['id' => $id]);
        $postRepository->removePost($post);
        return new JsonResponse(['status' => 'Customer deleted'], Response::HTTP_NO_CONTENT);
    }
    /**
     * @Route("/api/post/{id}", name="get_one_post", methods={"GET"})   
     */
    public function get($id,PostRepository $postRepository): JsonResponse {
        try {
            var_dump($id);
            $post = $postRepository->findOneBy(['id' => $id]);
            var_dump($post);
            $data = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'body' => $post->getBody(),
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        }catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/post", name="post", methods={"POST"})
     */
    public function add(Request $request,PostRepository $postRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $title = $data['title'];
        $body = $data['body'];
        if (empty($title) || empty($body)){
            throw new NotFoundHttpException('Expecting mandatory parameters');
        }
        $postRepository->savePost($title,$body);
        return new JsonResponse(['status' => 'Post Created'], Response::HTTP_CREATED);
    }
}
